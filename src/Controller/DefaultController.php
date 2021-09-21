<?php

namespace App\Controller;

use App\Entity\Cursos;
use App\Entity\Usuarios;
use App\Entity\Asignaturas;
use App\Entity\Usuarioasignatura;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends AbstractController {

    public function obtenersesion(){
        
        $session= new Session();
        if (!$session->has('usuario')){
            $session->start();
        }
        $con = $this->getDoctrine()->getManager();
        $bd = $con->getRepository(Usuarios::class);

        return $bd->findOneByUsuario($session->get('usuario'));
    }

    public function conexion(){
        return $this->getDoctrine()->getManager();
    }

    public function consulta($con,$nombre){
        if ($nombre == "Asignaturas"){
        $bd = $con->getRepository(Asignaturas::class);
        } elseif($nombre == "Cursos"){
        $bd = $con->getRepository(Cursos::class);
        } elseif($nombre == "Usuarios"){
            $bd = $con->getRepository(Usuarios::class);
            } elseif ($nombre == "Usuarioasignatura" ) {
                $bd = $con->getRepository(Usuarioasignatura::class);
            }
        return $bd->findAll();

    }
    
    /**
     * @Route ("/logout")
     */
    public function logout() {
        $session= new Session();
        $session->start();
        $session->remove('usuario');
        return $this->principal();
    }
     /**
         * @Route("/logearse"), name="logearse"
         * Funcion que comprueba si hay algun usuario 
         * si hay busca si coincide la pass
         */
        public function logearse(Request $request){
        $logeo=false;
        $em= $this->getDoctrine()->getRepository(Usuarios::class);
        $usuario_login= new Usuarios();
        $usuario= new Usuarios();

        if ($em->findOneByUsuario($request->get('usuario'))){
        $usuario_login= $em->findOneByUsuario($request->get('usuario'));
        if ($usuario_login->getPass() == md5($request->get('pass'))){
            $usuario=$usuario_login;
            // inicio sesion          
            $session = new Session();
            $session->start();
            $session->set('usuario', $usuario->getUsuario());
            $logeo=true;
            //cambiar de pag 
            } else {
                echo 'Usuario o contraseña no válidos';
            }
          
        } else {
            echo "Usuario o contraseña no válidos";
        }
        if ($logeo){
            return $this->asignaturas();
        } else {
            return $this->principal();
        }
}

       
    /**
     * @Route ("/registro")
     * muesta la plantilla de la pag principal 
     */
    public function registro() { 
        
        return $this->render('registro.html.twig');
    }
 
    /**
     * @Route ("/")
     * muesta la plantilla de la pag principal 
     */
    public function principal() { 
        
        return $this->render('login.html.twig');
    }
 
    
    /**
     * @Route ("/misdatos"), name="misdatos"
     */
    public function misdatos() { 
        $con = $this->conexion();
        $usuario = $this->obtenersesion();
        $misasignaturas= $this->consulta($con,'Usuarioasignatura');
        $asignaturas= $this->consulta($con,'Asignaturas');
        $cursos= $this->consulta($con,'Cursos');

        return $this->render('misdatos.html.twig', array(
            'usuario' => $usuario,
            'misasignaturas' => $misasignaturas,
            'asignaturas' => $asignaturas,
            'cursos' => $cursos
        ));
    }
    /**
     * @Route ("/cursos")
     */
    public function cursos() { 
        $con = $this->conexion();
        $cursos = $this->consulta($con,'Cursos');

        return $this->render('cursos.html.twig', array (
            'cursos' => $cursos
        ));
    }
    /**
     * @Route ("/usuarios")
     */
    public function usuarios() { 
        $con = $this->conexion();
        $usuarios = $this->consulta($con,'Usuarios');

        return $this->render('usuarios.html.twig', array (
            'usuarios' => $usuarios
        ));
    }
    
    /**
     * @Route ("/asignaturas")
     */
    public function asignaturas() { 
        $con = $this->conexion();
        $cursos = $this->consulta($con,'Cursos');
        $asignaturas = $this->consulta($con,'Asignaturas');
        
        return $this->render('asignaturas.html.twig', array (
            'cursos' => $cursos,
            'asignaturas' => $asignaturas
        ));
    }
     /**
     * @Route ("/detalles/{id}")
     */
    public function detalles(Cursos $curso) { 
        $con = $this->conexion();
        $asignaturas = $this->consulta($con,'Asignaturas');
        return $this->render('detalles.html.twig', array (
            'curso' => $curso,
            'asignaturas' => $asignaturas
        ));
    }

     /**
     * @Route ("/nuevousuario") , name="nuevousuario"
     */
    public function nuevousuario(Request $request) { 
        $con = $this->conexion();

        $usuario = new Usuarios();
        $usuario->setUsuario($request->get('usuario'));
        $usuario->setNombre($request->get('nombre'));
        $usuario->setApellidos($request->get('apellidos'));
        $usuario->setEmail($request->get('email'));
        $usuario->setPass(md5($request->get('pass')));

        $con->persist($usuario);
        $con->flush(); 
        return $this->principal();
        
    }
    /**
     * @Route ("/nuevaasignatura/{id}")
     */
    public function nuevaasignatura(Cursos $curso) { 
        return $this->render('nuevaasignatura.html.twig', array (
            'curso' => $curso
        ));
    }

    /**
     * @Route ("/nuevocurso")
     */
    public function nuevocurso() { 
        return $this->render('nuevocurso.html.twig'
        );
    }
    
    /**
     * @Route ("/formulariodatos")
     */
    public function formulariodatos() { 
        $usuario=$this->obtenersesion();
        return $this->render('editardatos.html.twig', array (
            'usuario' => $usuario
        )
        );
    }

    
    /**
     * @Route ("/crearasig/{id}")
     */
    public function crearasig(Cursos $curso, Request $request) { 
        $con = $this->conexion();

        $asignatura = new Asignaturas();
        $asignatura->setNombre($request->get('nombre'));
        $asignatura->setCreditos($request->get('creditos'));
        $asignatura->setDuracion($request->get('duracion'));
        $asignatura->setIdCurso($curso->getId());

        $con->persist($asignatura);
        $con->flush(); 

        return $this->detalles($curso);
    }

    
    /**
     * @Route ("/crearcurso"), name="crearcurso"
     */
    public function crearcurso(Request $request) { 
        $con = $this->conexion();

        $curso= new Cursos();
        $curso->setCurso($request->get('curso'));
        $curso->setTitulacion($request->get('titulacion'));
        $curso->setDuracion($request->get('duracion'));
        $curso->setAnio($request->get('anio'));
        $con->persist($curso);
        $con->flush(); 

        return $this->cursos();
    }

     /**
     * @Route ("/editardatos") , name="editardatos"
     */
    public function editardatos(Request $request) { 
        $con = $this->conexion();
        $miusuario= $this->obtenersesion();

        $miusuario->setUsuario(''.$request->get('usuario'));
        $miusuario->setNombre(''.$request->get('nombre'));
        $miusuario->setApellidos(''.$request->get('apellidos'));
        $miusuario->setEmail(''.$request->get('email'));
        $miusuario->setPass(md5(''.$request->get('pass')));

        
        $session= new Session();
        if (!$session->has('usuario')){
            $session->start();
        }
        $session->set('usuario', $miusuario->getUsuario());

        $con->persist($miusuario);
        $con->flush(); 
        return $this->misdatos();
        
    }
     
    /**
     * @Route ("/apuntarse/{id}")
     */
    public function apuntarse(Asignaturas $asignatura) { 
        $usuario = $this->obtenersesion();
        $con = $this->conexion();
        $miasignatura= new Usuarioasignatura();
        $miasignatura->setIdUsuario($usuario->getId());
        $miasignatura->setIdAsignatura($asignatura->getId());

        $con->persist($miasignatura);
        $con->flush();
        return $this->misdatos();
    }

    /**
     * @Route("/detalleasignatura/{id}")
     */
    public function detalleasignatura(Asignaturas $asignatura){
        return $this->render('detallesasignatura.html.twig', array (
            'asignatura' => $asignatura
        ));
    }

        /**
     * @Route("/editarasignatura/{id}")
     */
    public function editarasignatura(Asignaturas $asignatura, Request $request){

        $con= $this->conexion();
        $asignatura->setNombre($request->get('nombre'));
        $asignatura->setCreditos($request->get('creditos'));
        $asignatura->setDuracion($request->get('duracion'));

        $bd= $con->getRepository(Cursos::class);
        $curso = $bd->findOneById($asignatura->getIdCurso());

        $con->persist($asignatura);
        $con->flush();

        return $this->detalles($curso);
    
    }

        /**
     * @Route("/borrarasig/{id}")
     */
    public function borrarasig(Asignaturas $asignatura){

        $con= $this->conexion();

        $bd= $con->getRepository(Cursos::class);
        $curso = $bd->findOneById($asignatura->getIdCurso());

        $con->remove($asignatura);
        $con->flush();

        return $this->detalles($curso);
    
    }
}

?>