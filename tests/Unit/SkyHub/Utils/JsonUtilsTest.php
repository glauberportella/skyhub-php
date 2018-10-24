<?php

namespace Tests\Unit\SkyHub\Utils;

use SkyHub\Resource\Product;
use SkyHub\Utils\JsonUtils;

class JsonUtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testSafeJsonEncodeShouldWorks()
    {
        $product = $this->createTestProduct();
        $this->assertInstanceOf('\SkyHub\Resource\Product', $product);

        $encoded = JsonUtils::safe_json_encode($product);
        // you can save a file to check later the encode
        //file_put_contents(dirname(__FILE__).'/../../../data/safe_json_encode_test.txt', $encoded);
        // only verify if encoding was fine
        $this->assertTrue(false !== $encoded);
    }

    private function createTestProduct()
    {
        $product = new Product();
        $product->fromArray(array(
            'sku' => '3325',
            'name' => 'Válvula Esfera MGA Tripartida 1/2 NPT 300',
            'description' => '<p><strong>Válvula de Esfera MGA Tripartida 1/2 NTP Classe 300</strong>, indicada para uso em vários líquidos, gases e vapores, em indústria, comércio e residência.</p>
        
        Válvulas Esfera: Válvula de Esfera MGA Tripartida 1/2 NTP Classe 300.
        <p>Tripartida.<br />Classe 300.<br />NPT.<br />Niple Estendido.<br />Passagem reduzida.</p>
        3325 - Válvula de Esfera MGA Tripartida 1/2 NTP Classe 300, passagem reduzida.
        Informação da válvula esfera tripartida:
        <ul>
        <li>Válvula de bloqueio de fluxo.</li>
        <li>Esfera.</li>
        <li>Tripartida. (um corpo e duas tampas)</li>
        </ul>
        Classe
        <ul>
        <li>300</li>
        <li>Passagem:</li>
        <li>Reduzida.</li>
        </ul>
        Rosca
        <ul>
        <li>NPT</li>
        <li>1/2</li>
        </ul>
        Acionamento
        <ul>
        <li>1/4 de volta. (90º).</li>
        <li>Reduz o tempo de fechamento.</li>
        </ul>
        Vedação
        <ul>
        <li>PTFE ou COMPL</li>
        </ul>
        Marca
        <ul>
        <li>MGA - Metalúrgica Golden Art’s.</li>
        </ul>
        Norma
        <ul>
        <li>ASME B16.34.</li>
        </ul>
        Haste
        <ul>
        <li>Prova de expulsão.</li>
        </ul>
        Vedação
        <ul>
        <li>Sistema vedação enclausurada.</li>
        </ul>
        Gás:
        <ul>
        <li>GLP (Gás Liquefeito de Petróleo).</li>
        <li>GN (Gás Natural).</li>
        </ul>
        Pressão:
        <ul>
        <li>Baixa Pressão.</li>
        <li>Alta Pressão.</li>
        </ul>
        Utilização da MGA válvulas
        Diversos
        <ul>
        <li>Gases.</li>
        <li>Líquidos.</li>
        <li>Vapores.</li>
        </ul>
        Instalação de equipamentos
        <ul>
        <li>Central de Gás.</li>
        <li>Forno Industrial.</li>
        <li>Rede de Gás.</li>
        <li>Aquecedores de Gás.</li>
        <li>Fogão Industrial.</li>
        <li>Queimadores Industrial.</li>
        </ul>
        Cuidado! Com a válvula de esfera:
        Verificar
        <ul>
        <li>Condição de Pressão.</li>
        <li>Temperatura do fluido.</li>
        <li>Vistoriar a tubulação antes da instalação da válvula:</li>
        <li>Pode ter sujeira na rede.</li>
        <li>Pôr a válvula na posição “aberta” durante a instalação:</li>
        <li>Evitando dano a esfera.</li>
        <li>Ver o alinhamento:</li>
        <li>Tubulação.</li>
        <li>Furação dos flanges.</li>
        <li>Alinhamento axial é essencial para válvulas roscadas.</li>
        <li>O alinhamento da tubulação não deve ser feito com a instalação da válvula.</li>
        </ul>
        O que faz a válvula de esfera tripartida
        Idealizada
        <ul>
        <li>Fluxo bidirecional:</li>
        <li>A menos que a esfera seja dotada de furo de alívio ou contato.</li>
        <li>Abertura e Fechamento:</li>
        <li>Giro ¼ de volta (90º) no sentido horário para o fechamento e anti-horário para abertura.</li>
        <li>Válvulas de bloqueio:</li>
        <li>on/off.</li>
        <li>Trabalham somente em duas posições:</li>
        <li>Aberta ou fechada.</li>
        <li>Não podem ser utilizadas para regular a vazão do fluido</li>
        </ul>
        A manutenção da válvula de esfera alta pressão
        Consiste
        <ul>
        <li>Troca de vedação.</li>
        <li>Aperto de parafusos:</li>
        <li>Aperto em excesso, pode prejudicar o torque de acionamento.</li>
        <li>Desgaste das vedações.</li>
        <li>Para suprimir vazamentos na haste aperte os parafusos do preme gaxeta com oitavo de volta a cada vez.</li>
        <li>Caso necessite manutenção dos componentes interno:</li>
        <li>Verifique se a válvula esteja despressurizada.</li>
        <li>Use sempre peças e reposição originais.</li>
        </ul>
        <p><strong>A Consigás Comércio de Peças e Aparelhos a Gás</strong>, comercializa uma linha de válvula de esfera, Bi e Tripartida, Flangeada e Monobloco, para tornar sua obra de qualidade e segurança.</p>
        O que é rosca NPT?
        <ul>
        <li>NPT (sigla para National Pipe Thread, "rosca nacional)</li>
        <li>Conhecida como rosca gás.</li>
        <li>Rosca cônica.</li>
        <li>Uso em conexões de tubulação de água, gás, etc.</li>
        <li>Ao rosquear uma conexão com rosca NPT, em um tubo ou conexão, chega a um ponto que o diâmetro fica maior do que o furo, ocorrendo a trava e vedação.</li>
        </ul>',
            'status' => 'enabled',
            'qty' => 6,
            'price' => 44,
            'promotional_price' => 44,
            'cost' => 25.3599999999999994315658113919198513031005859375,
            'weight' => '0.490000',
            'height' => '2.000000',
            'width' => '16.000000',
            'length' => '11.000000',
            'brand' => 'MGA - Metalúrgica Golden Art�',
            'ean' => '',
            'nbm' => '',
            'categories' => 
            array (
              0 => 
              array (
                'code' => '2.63',
                'name' => 'Inicio > Gás',
              ),
              1 => 
              array (
                'code' => '2.63.87',
                'name' => 'Inicio > Gás > Válvulas Esfera',
              ),
              2 => 
              array (
                'code' => '2.97',
                'name' => 'Inicio > Ofertas',
              ),
              3 => 
              array (
                'code' => '2.97.98',
                'name' => 'Inicio > Ofertas > Promocões da Semana',
              ),
            ),
            'images' => 
            array (
              0 => 'https://www.consigaspecas.com.br/2072-large_default/valvula-esfera-mga-tripartida-1-2-npt-300-3325.jpg',
              1 => 'https://www.consigaspecas.com.br/2073-large_default/valvula-esfera-mga-tripartida-1-2-npt-300-3325.jpg',
              2 => 'https://www.consigaspecas.com.br/2071-large_default/valvula-esfera-mga-tripartida-1-2-npt-300-3325.jpg',
              3 => 'https://www.consigaspecas.com.br/2074-large_default/valvula-esfera-mga-tripartida-1-2-npt-300-3325.jpg',
              4 => 'https://www.consigaspecas.com.br/2075-large_default/valvula-esfera-mga-tripartida-1-2-npt-300-3325.jpg',
            ),
            'specifications' => 
            array (
              0 => 
              array (
                'key' => 'Tipo de Gás',
                'value' => 'GLP (Gás Liquefeito de Petróleo). GN (Gás Natural).',
              ),
              1 => 
              array (
                'key' => 'Peso',
                'value' => '0,49 Kg',
              ),
              2 => 
              array (
                'key' => 'Tipo de Rosca',
                'value' => 'NPT',
              ),
              3 => 
              array (
                'key' => 'Pressão',
                'value' => 'Baixa Pressão 
        Alta Pressão',
              ),
              4 => 
              array (
                'key' => 'Material',
                'value' => 'WCB, CF8 e CF8M.',
              ),
              5 => 
              array (
                'key' => 'Bitola',
                'value' => 'NPT 1/2
        ',
              ),
              6 => 
              array (
                'key' => 'Item 01',
                'value' => '3325 - Válvula de Esfera MGA Tripartida 1/2 NTP Classe 300.',
              ),
              7 => 
              array (
                'key' => 'Uso',
                'value' => 'Indicada para uso em vários líquidos, gases e vapores, em indústria, comércio e residência.',
              ),
              8 => 
              array (
                'key' => 'Inflamabilidade',
                'value' => 'sim',
              ),
              9 => 
              array (
                'key' => 'Normas',
                'value' => 'ASME B16.34.',
              ),
              10 => 
              array (
                'key' => 'Garantia',
                'value' => 'Válvulas Esfera: Válvula de Esfera MGA Tripartida 1/2 NTP Classe 300.',
              ),
              11 => 
              array (
                'key' => 'price',
                'value' => 44,
              ),
              12 => 
              array (
                'key' => 'promotional_price',
                'value' => 44,
              ),
              13 => 
              array (
                'key' => 'CrossDocking',
                'value' => '4',
              ),
            ),
            'variations' => 
            array (
              0 => 
              array (
                'sku' => 'skhb-277-var-15016',
                'qty' => 6,
                'ean' => '',
                'images' => 
                array (
                  0 => 'https://www.consigaspecas.com.br/2072-large_default/valvula-esfera-mga-tripartida-1-2-npt-300-3325.jpg',
                  1 => 'https://www.consigaspecas.com.br/2073-large_default/valvula-esfera-mga-tripartida-1-2-npt-300-3325.jpg',
                ),
                'specifications' => 
                array (
                  0 => 
                  array (
                    'key' => 'CrossDocking',
                    'value' => '4',
                  ),
                  1 => 
                  array (
                    'key' => 'Tipos',
                    'value' => 'Tri-Partida',
                  ),
                  2 => 
                  array (
                    'key' => 'Modelo',
                    'value' => 'Passagem Reduzida',
                  ),
                  3 => 
                  array (
                    'key' => 'price',
                    'value' => 44,
                  ),
                  4 => 
                  array (
                    'key' => 'promotional_price',
                    'value' => 44,
                  ),
                ),
              ),
            ),
            'variation_attributes' => 
            array (
              0 => 'Modelo',
              1 => 'Tipos',
            ),
          )
        );

        return $product;
    }
}