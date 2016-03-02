<tr>
    <td class="content-wrap aligncenter">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-block">
                    <h2 class="aligncenter">Reserva</h2>
                </td>
            </tr>
            <tr>
                <td class="content-block aligncenter">
                    <table class="invoice">
                        <tr>
                            <td>
                                <table class="invoice-items" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>Código da Reserva</td>
                                        <td class="alignright">{{ $codigo_reserva }}</td>
                                    </tr>
                                    <tr>
                                        <td>Data da Reserva</td>
                                        <td class="alignright">{{ $data_reserva }}</td>
                                    </tr>
                                    <tr>
                                        <td>Horário da Reserva</td>
                                        <td class="alignright">{{ $horario_reserva }}</td>
                                    </tr>
                                    <tr>
                                        <td>Reservado para</td>
                                        <td class="alignright">{{ $qtd_clientes }} pessoa(s)</td>
                                    </tr>
                                    <tr>
                                        <td>Menu Reservado</td>
                                        <td class="alignright">{{ $titulo_menu }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nome do Chef</td>
                                        <td class="alignright">{{ $nome_chef }}</td>
                                    </tr>
                                    @if(!empty($observacao))
                                        <tr>
                                            <td>Observação</td>
                                            <td class="alignright">{{ $observacao }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td class="content-wrap aligncenter">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-block">
                    <h2 class="aligncenter">Endereço</h2>
                </td>
            </tr>
            <tr>
                <td class="content-block aligncenter">
                    <table class="invoice">
                        <tr>
                            <td>
                                <table class="invoice-items" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>CEP</td>
                                        <td class="alignright">{{ $cep }}</td>
                                    </tr>
                                    <tr>
                                        <td>Rua/Número</td>
                                        <td class="alignright">{{ $logradouro }}, {{ $logradouro_numero }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bairro</td>
                                        <td class="alignright">{{ $bairro }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cidade</td>
                                        <td class="alignright">{{ $nome_cidade }}</td>
                                    </tr>
                                    <tr>
                                        <td>Estado - País</td>
                                        <td class="alignright">{{ $nome_estado }} - {{ $nome_pais }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td class="content-wrap aligncenter">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-block">
                    <h2 class="aligncenter">Informações de Pagamento</h2>
                </td>
            </tr>
            <tr>
                <td class="content-block aligncenter">
                    <table class="invoice">
                        <tr>
                            <td>
                                <table class="invoice-items" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>Preço por pessoa</td>
                                        <td class="alignright">R$ {{ formatar_monetario($preco_por_cliente) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Quantidade de pessoas</td>
                                        <td class="alignright">{{ $qtd_clientes }}</td>
                                    </tr>
                                    <tr>
                                        <td>Taxa de Serviço La Mesa Bonita</td>
                                        <td class="alignright">R$ {{ formatar_monetario($taxa_lmb) }}</td>
                                    </tr>
                                    <tr class="total">
                                        <td class="alignright" width="80%">Total</td>
                                        <td class="alignright">R$ {{ formatar_monetario($preco_total) }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>