<?php
namespace PhpSigep\Model;
class AccessDataHomologacao extends AccessData 
{

    public function __construct()
    {
        if (AMBIENTE) {//ENV_PRODUCTION           
            parent::__construct(
                array(
                'usuario'           => USUARIO,
                'senha'             => SENHA,
                'numeroContrato'    => CONTRATO,
                'codAdministrativo' => CODADMIN,
                'cartaoPostagem'    => CARTAO,
                'cnpjEmpresa'       => CNPJ,
                'anoContrato'       => ANO_CONTRATO,
                'diretoria'         => new Diretoria(ID_DIRETORIA), 
                )
            );

        try {\PhpSigep\Bootstrap::getConfig()->setEnv(\PhpSigep\Config::ENV_PRODUCTION);} catch (\Exception $e) {}

        }else{ //ENV_DEVELOPMENT
            parent::__construct(
                array(
                'usuario'           => 'sigep',
                'senha'             => 'n5f9t8',
                'numeroContrato'    => '9992157880',
                'cartaoPostagem'    => '0067599079',
                'codAdministrativo' => '321654987',
                'cnpjEmpresa'       => '34028316000103',
                'anoContrato'       => null,
                'diretoria'         => new Diretoria(Diretoria::DIRETORIA_DR_BRASILIA), 
                )
            );

        try {\PhpSigep\Bootstrap::getConfig()->setEnv(\PhpSigep\Config::ENV_DEVELOPMENT);} catch (\Exception $e) {}
        }
    }
}
// buscar dados da cliente sigep no banco de dados
