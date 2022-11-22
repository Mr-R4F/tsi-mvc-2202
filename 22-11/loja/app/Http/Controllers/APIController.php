<?php
//controler par fazer o login /token/ logout
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth; //colocar isso
use App\Model\User; //model
use Tymon\JWTAuth\Exceptions\JWTException; //e pacote tymon

class APIController extends Controller
{
    //criar atributo e método para fazer o login e receber o token
    public $loginAfterSignUp = true;

    public function login(Request $request) { //
        $token = null;
        $camposJSON = json_decode($request->getContent(), JSON_OBJECT_AS_ARRAY); //espera recebe as credenciais (email e senha, nesse casio) (transforma o json para vetor)
        $credenciais = array(  //criar vetor com os indices para receber os dados do usuario
            'email' => $camposJSON['email'],
            'password' => $camposJSON['password']
        );

        try {
            if(!$token = JWTAuth::attempt($credenciais)) { //se o token não for recebido ( se houver erro na tentativa) (inválidas)
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciais inválidas'
                ], 401); //devolve o jsno com campo sucesso e bool falso e mensagem ( e 401 que retorna par ao solicitante o código HTTP 401)
            }
        } catch (JWTExeception $e) { //se houver exc 9se não conseguir criar o token  o erro vai para a aplicação que está fazendo a solicitação
            return response()->json(['error' => 'Token não pode ser criado'], 500);
        }

        return response()->json([
            'success' => true,
            'token' => $token
        ], 200); //se recebeu o token e retorna 200.
    }

    //para método de logout (não é muito comum em API)
    public function logout(Request $request) { //invalida o token
        try {
            JWTAuth::invalidate(JWTAuth::getToken()); //pega o token usado e o invalida
            return response()->json([
                'success' => true,
                'message' => 'Token invalidado'
            ]);
        } catch (JWTExeception $e) { //se houver excessão (objeto de excessão e passa dos 128 MB)
            return response()->json([ //espera recebe vetor com dados e código HTTP a ser devolvido
                'success' => false,
                'message' => 'Erro ao invalidar o token',
                'error' => var_export($e->getMessage())  //mostra ao usuario o erro (para não estourar a memoria)
            ], 500);
        }
    }
}
