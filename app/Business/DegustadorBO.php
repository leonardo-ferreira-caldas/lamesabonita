<?php

namespace App\Business;

use App\Constants\ClienteConstants;
use App\Constants\FavoritoConstants;
use App\Exceptions\ErrorException;
use App\Exceptions\InfoException;
use App\Exceptions\UnexpectedErrorException;
use App\Facades\Autenticacao;
use App\Facades\Upload;
use App\Mappers\RepositoryMapper;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DB;
use App\Utils\Alert;

class DegustadorBO
{

    private $repository;

    public function __construct(RepositoryMapper $mapper)
    {
        $this->repository = $mapper;
    }

    /**
     * Altera a foto de pefil do cliente logado
     *
     * @param UploadedFile $file
     * @return void
     */
    public function alterarFotoPerfil(UploadedFile $file)
    {

        $cliente = $this->repository->cliente->findById(Autenticacao::getId());

        $fotoPerfil = Upload::salvar($file, 'foto-perfil-cliente');

        $this->repository->cliente->alterarAvatar(Autenticacao::getId(), $fotoPerfil);

        if ($cliente->avatar != ClienteConstants::DEFAULT_AVATAR) {
            Upload::deletar($cliente->avatar);
        }

    }

    /**
     * Altera os dados/informações pessoais do cliente logado
     *
     * @param $dadosRequisicao
     * @throws Exception
     */
    public function alterarDados($dadosRequisicao)
    {

        DB::beginTransaction();

        try {

            $dadosRequisicao['descricao'] = 'Endereço Principal';
            $this->repository->user->atualizarNome(Autenticacao::getId(), $dadosRequisicao['name']);
            $this->repository->cliente_endereco->salvarEnderecoPrincipal(Autenticacao::getId(), $dadosRequisicao);
            $this->repository->cliente->atualizarDados(Autenticacao::getId(), $dadosRequisicao);

            DB::commit();
        } catch (Exception $excpt) {
            DB::rollBack();

            throw new UnexpectedErrorException;
        }

    }

    /**
     * Insere um novo endereço para o cliente logado
     *
     * @param array $dadosEndereco
     * @return void
     */
    public function salvarNovoEndereco(array $dadosEndereco)
    {

        try {

            if (!$this->repository->geo->paisExiste($dadosEndereco["fk_pais"])) {
                throw new Exception("O país informado não é válido.");
            } else if (!$this->repository->geo->estadoExiste($dadosEndereco["fk_estado"])) {
                throw new Exception("O estado informado não existe.");
            } else if (!$this->repository->geo->cidadeExiste($dadosEndereco["fk_cidade"])) {
                throw new Exception("A cidade informada não é válida.");
            } else if (empty($dadosEndereco["descricao"])) {
                throw new Exception("Informe a descrição para o endereço.");
            } else if (empty($dadosEndereco["cep"])) {
                throw new Exception("Informe um CEP válido para o endereço.");
            } else if (empty($dadosEndereco["logradouro"])) {
                throw new Exception("Informe a rua/logradouro para o endereço.");
            } else if (empty($dadosEndereco["logradouro_numero"])) {
                throw new Exception("Informe o número da rua/logradouro para o endereço.");
            }

            $this->repository->cliente_endereco->inserirEndereco(Autenticacao::getId(), $dadosEndereco, false);

        } catch (Exception $e) {
            Alert::error("Validação", $e->getMessage());
        }

    }

    /**
     * Retorna todos os endereços do usuário logado
     *
     * @return mixed
     */
    public function buscarEnderecosUsuarioLogado()
    {
        return $this->buscarEnderecos(Autenticacao::getId());
    }

    /**
     * Busca todos os endereços de um cliente
     *
     * @param $idDegustador
     * @return mixed
     */
    public function buscarEnderecos($idCliente)
    {
        return $this->repository->cliente_endereco->getEnderecos($idCliente);
    }

    /**
     * Busca os dados de um endereço
     *
     * @param $idEndereco
     * @return mixed
     */
    public function buscarDadosEndereco($idEndereco)
    {
        return $this->repository->cliente_endereco->getDadosEndereco($idEndereco);
    }

    /**
     * Retorna lista com todos os favoritos do cliente logado
     *
     * @return array of stdClass
     */
    public function getListaFavoritos()
    {
        return $this->repository->favorito->getFavoritosByClienteId(Autenticacao::getId());
    }

    /**
     * Busca informações discretas que serão usadas para preencher comboboxes
     *
     * @return array
     */
    public function buscarInformacoesDiscretas()
    {

        $cidades = [];
        $enderecoPrincipal = $this->repository->cliente_endereco->getEnderecoPrincipal(Autenticacao::getId());

        if (!empty($enderecoPrincipal)) {
            $cidades = $this->repository->geo->filtrarCidades($enderecoPrincipal->fk_estado);
        }

        return [
            'paises' => $this->repository->geo->listarPaises(),
            'estados' => $this->repository->geo->listarEstados(),
            'cidades' => $cidades,
            'sexos' => $this->repository->sexo->all()
        ];
    }

    /**
     * Atualiza o status do newsletter do cliente logado
     *
     * @return mixed
     */
    public function atualizarStatusNewsletter()
    {
        if ($this->repository->cliente->getNewsletterStatus(Autenticacao::getId())) {
            return $this->repository->cliente->atualizarNewsletter(Autenticacao::getId(), false);
        }

        return $this->repository->cliente->atualizarNewsletter(Autenticacao::getId(), true);
    }

    /**
     * Verifica se o clinte que está logado possui newsletter habilitado
     *
     * @return mixed
     */
    public function getNewsletterHabilitado()
    {
        return $this->repository->cliente->getNewsletterStatus(Autenticacao::getId());
    }

    /**
     * Retorna os dados do cliente logado
     *
     * @return stdClass
     */
    public function getDadosClienteLogado()
    {
        return $this->repository->cliente->getDadosCliente(Autenticacao::getId());
    }

    /**
     * Remove um menu/curso da lista de favorito do usuário logado
     *
     * @param string $slug Identificador do menu/curso
     * @param string $tipo Identifica se é menu ou curso
     * @return void
     */
    public function removerFavorito($slug, $tipo)
    {
        if (Autenticacao::isChef()) {
            throw new ErrorException("Chef's não podem ter favoritos.");
        }

        switch ($tipo) {
            case FavoritoConstants::TIPO_MENU:

                $menu = $this->repository->menu->findBySlug($slug, true);

                if (!$this->repository->favorito->verificaMenuJaAdicionado(Autenticacao::getId(), $menu->id_menu)) {
                    throw new InfoException("O menu não está na sua lista de favoritos.");
                }

                $this->repository->favorito->deletarMenu(Autenticacao::getId(), $menu->id_menu);
                break;

            case FavoritoConstants::TIPO_CURSO:

                $curso = $this->repository->curso->findBySlug($slug, true);

                if (!$this->repository->favorito->verificaCursoJaAdicionado(Autenticacao::getId(), $curso->id_curso)) {
                    throw new InfoException("O curso não está na sua lista de favoritos.");
                }

                $this->repository->favorito->deletarCurso(Autenticacao::getId(), $curso->id_curso);
                break;

            default:
                throw new UnexpectedErrorException;
        }

    }

    /**
     * Adiciona um menu/curso a lista de favorito do usuário logado
     *
     * @param string $slug Identificador do menu/curso
     * @param string $tipo Identifica se é menu ou curso
     * @return void
     */
    public function adicionarFavorito($slug, $tipo) {
        if (Autenticacao::isChef()) {
            throw new ErrorException("Chef's não podem adicionar favoritos.");
        }

        switch ($tipo) {
            case FavoritoConstants::TIPO_MENU:

                $menu = $this->repository->menu->findBySlug($slug, true);

                if ($this->repository->favorito->verificaMenuJaAdicionado(Autenticacao::getId(), $menu->id_menu)) {
                    throw new InfoException("O menu já está na sua lista de favoritos.");
                }

                $this->repository->favorito->adicionarMenu(Autenticacao::getId(), $menu->id_menu);
                break;

            case FavoritoConstants::TIPO_CURSO:

                $curso = $this->repository->curso->findBySlug($slug, true);

                if ($this->repository->favorito->verificaCursoJaAdicionado(Autenticacao::getId(), $curso->id_curso)) {
                    throw new InfoException("O curso já está na sua lista de favoritos.");
                }

                $this->repository->favorito->adicionarCurso(Autenticacao::getId(), $curso->id_curso);
                break;

            default:
                throw new UnexpectedErrorException;
        }
    }

}