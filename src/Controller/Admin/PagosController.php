<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;


require_once(ROOT . DS  . 'vendor' . DS . 'mercadopago.php');
use MP;

class PagosController extends AppController{

    public function initialize(){
        parent::initialize();
    }

    public function beforeFilter(Event $event){
        $this->Auth->allow(['ws','wstienda','test']);
    }

    public function beforeRender(Event $event){
        $mediosPago = [
            'Pago en Efectivo'        => 'Pago en Efectivo',
            'MercadoPago'             => 'MercadoPago',
            'Transferencia Bancaria'  => 'Transferencia Bancaria',
            'Todo Pago'               => 'Todo Pago',
            'Pago Fácil'              => 'Pago Fácil',
            'Otro'                    => 'Otro'
        ];
        $this->set(compact('mediosPago'));
    }

    public function index(){

        $pagos = $this->Pagos->find('all')->contain(['Usuarios']);

        if(!empty($this->request->query)){
                
            $search = $this->request->query['q'];
            $pagos->where([
                'AND' => [ 
                    'OR' => [
                        ['Usuarios.nombre LIKE' => '%' . $search . '%'],
                        ['Usuarios.apellido LIKE' => '%' . $search . '%'],
                        ['Usuarios.email LIKE' => '%' . $search . '%'],
                        ['Pagos.status LIKE' => '%' . $search . '%'],
                        ['Pagos.datos LIKE' => '%' . $search . '%'],
                    ]
                ]
            ]);

            if(!empty($this->request->query['fecha_desde'])){
                $pagos->where(['Pagos.created >=' => new Time($this->request->query['fecha_desde'])]);
            }
            if(!empty($this->request->query['fecha_hasta'])){
                $pagos->where(['Pagos.created <=' => new Time($this->request->query['fecha_hasta'])]);
            }
            if(!empty($this->request->query['origen'])){
                $pagos->where(['Pagos.origen' => $this->request->query['origen']]);
            }
        }

        $this->set('pagos', $this->paginate($pagos));
        $this->set('pagosExport', $pagos->limit(10000000000));

    }

    public function agregar(){
        $this->loadModel('Usuarios');
        $participantes = $this->Usuarios->find('list');
        $this->set('participantes', $participantes);

        $this->loadModel("Usuarios");
        $user = $this->Usuarios->get($this->Auth->user('id'));
        $this->set(compact('user'));

        $pago = $this->Pagos->newEntity();
        if ($this->request->is('post')) {
            
            $diasSumar = $this->request->data['dias'];
            unset($this->request->data['dias']);

            $pago = $this->Pagos->patchEntity($pago, $this->request->data);
            if ($this->Pagos->save($pago)) {

                if(!empty($diasSumar)){

                    $participanteActual = $this->Usuarios->get($this->request->data['usuario_id']);
                    if(!empty($participanteActual)){

                        $diasSumar = (int) $diasSumar;

                        if(empty($participanteActual->licencia)){
                            $participanteActual->licencia = date("Y-m-d", strtotime("+".$diasSumar." days"));
                        }else{
                            $participanteActual->licencia = date("Y-m-d", strtotime($participanteActual->licencia->format('Y-m-d')." +".$diasSumar." days"));
                        }

                        try {
                            $emailParticipante = $participanteActual->email;
                            $email = new Email('Sendgrid');
                            $email->from(['alertas@doctorya.com.ar' => 'DoctorYA'])
                                ->template('notificacion_pago', 'limpio')
                                ->emailFormat('html')
                                ->to($emailParticipante)
                                ->subject('¡Tu pago se registró con éxito!')
                                ->viewVars(['mail' => $emailParticipante, 'clave' => $participanteActual->clave])
                                ->send();
                        } catch (\Exception $e) {
                            // $this->out();
                        }

                        if ($this->Usuarios->save($participanteActual)){
                            $this->Flash->success(__('Se guardó con éxito.'));
                            return $this->redirect(['action' => 'index']);
                        } else{
                            $this->Flash->ePublico(__('Ocurrió un error. Por favor, intente nuevamente.'));
                        }

                    }
                }

                $this->Flash->success(__('Se agregó con éxito.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->ePublico(__('Ocurrió un error. Por favor, intente nuevamente.'));
            }
        }
        $this->set(compact('pago'));

    }

    public function eliminar($id = null){
        
        $pago = $this->Pagos->get($id);
        if ($this->Pagos->delete($pago)) {
            $this->Flash->success(__('El pago se elimino con exito.'));
        } else {
            $this->Flash->ePublico(__('Hubo un error al eliminar. Por favor intenta nuevamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function test(){
        /*
        $this->viewBuilder()->layout('ajax');
        $pagoExistente = $this->Pagos->find('all')->where(['Pagos.mp_id' => "282918958-16025c8d-9512-49a3-8d92-2966adfeefd5"])->count();
        if(empty($pagoExistente))
            echo "VACIO";
        else
            echo $pagoExistente;
        //var_dump($pagoExistente);
        */
        exit();
    }


    public function ws(){
        
        $this->viewBuilder()->layout('ajax');
        $this->Usuarios = TableRegistry::get('Usuarios');


        echo "IPN Mercado Pago <br /><br />";
        $emailAlerta  = "julianbutti@gmail.com";

        $mp = new MP (CLIENT_ID, CLIENT_SECRET);

        if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
            http_response_code(400);
            return;
        }


        $topic = $_GET["topic"];
        $merchant_order_info = null;

        switch ($topic) {
            case 'payment':
                $payment_info = $mp->get("/collections/notifications/".$_GET["id"]);
                $merchant_order_info = $mp->get("/merchant_orders/".$payment_info["response"]["collection"]["merchant_order_id"]);
                break;
            case 'merchant_order':
                $merchant_order_info = $mp->get("/merchant_orders/".$_GET["id"]);
                break;
            default:
                $merchant_order_info = null;
        }


        if($merchant_order_info == null) {
            echo "Error obtaining the merchant_order";
            return;
        }

        if ($merchant_order_info["status"] == 200) {
            $transaction_amount_payments= 0;
            $transaction_amount_order = $merchant_order_info["response"]["total_amount"];
            $payments = $merchant_order_info["response"]["payments"];
            foreach ($payments as  $payment) {
                if($payment['status'] == 'approved'){
                    $transaction_amount_payments += $payment['transaction_amount'];
                }   
            }



            $bodyAdmin = serialize($merchant_order_info["response"]);
            //mail($emailAlerta, "Recibo un pago en MP" , $bodyAdmin);

            $nuevoPago = $this->Pagos->newEntity();
            $nuevoPago->datos = $bodyAdmin;
            $nuevoPago->monto = $transaction_amount_payments;
            $nuevoPago->origen = 'MercadoPago';
            $nuevoPago->status = 'Pendiente';
            $nuevoPago->mp_id = $merchant_order_info["response"]["preference_id"];

            $pagoExistente = $this->Pagos->find('all')->where(['Pagos.mp_id' => $merchant_order_info["response"]["preference_id"]])->count();
            if(empty($pagoExistente)){
                //Valido que este pago no se haya registrado antes, evitamos duplicados...

                if($transaction_amount_payments >= $transaction_amount_order){

                    //El pago fue por un Registro
                    if($merchant_order_info["response"]["additional_info"] == "registro"){

                        $participante_id = $merchant_order_info["response"]["external_reference"];
                        if(!empty($participante_id)){
                            $participanteActual = $this->Usuarios->get($participante_id);
                            //Si el participante existe en la DB
                            if(!empty($participanteActual)){
                                $nuevoPago->participante_id = $participanteActual->id;
                                if(empty($participanteActual->licencia)){
                                    //Le sumo 30 días a la licencia desde hoy
                                    $participanteActual->licencia = date("Y-m-d", strtotime("+90 days"));
                                }else{
                                    //Le sumo 30 días a la licencia desde el vencimiento actual
                                    $participanteActual->licencia = date("Y-m-d", strtotime($participanteActual->licencia->format('Y-m-d')." +90 days"));
                                }

                                if ($this->Usuarios->save($participanteActual)){
                                    //mail($emailAlerta,"OK en Pago Dr Dieta","id: ".$participante_id.".");
                                    $nuevoPago->status = 'Aprobado';
                                } else{
                                    //mail($emailAlerta,"Error en Pago Dr Dieta","id: ".$participante_id.".");
                                    $nuevoPago->status = 'Con Error';
                                }
                                //Actualizo el pago en curso
                                @$this->Pagos->save($nuevoPago);

                                try {
                                    $emailParticipante = $participanteActual->email;
                                    $email = new Email('Sendgrid');
                                    $email->from(['alertas@doctorya.com.ar' => 'DoctorYA'])
                                        ->template('notificacion_pago', 'limpio')
                                        ->emailFormat('html')
                                        ->to($emailParticipante)
                                        ->bcc(["admin@doctorya.com.ar", "consultas@doctorya.com.ar"])
                                        ->subject('¡Tu pago se registró con éxito!')
                                        ->viewVars(['mail' => $emailParticipante, 'clave' => $participanteActual->clave])
                                        ->send();
                                } catch (\Exception $e) {
                                    // $this->out();
                                }
                            }
                        }
                    }
                    
                    //El pago fue por renovar 1 mes
                    if($merchant_order_info["response"]["additional_info"] == "renovar1"){

                        $participante_id = $merchant_order_info["response"]["external_reference"];
                        if(!empty($participante_id)){
                            $participanteActual = $this->Usuarios->get($participante_id);
                            //Si el participante existe en la DB
                            if(!empty($participanteActual)){
                                $nuevoPago->participante_id = $participanteActual->id;
                                if(empty($participanteActual->licencia)){
                                    //Le sumo 30 días a la licencia desde hoy
                                    $participanteActual->licencia = date("Y-m-d", strtotime("+30 days"));
                                }else{
                                    //Le sumo 30 días a la licencia desde el vencimiento actual
                                    $participanteActual->licencia = date("Y-m-d", strtotime($participanteActual->licencia->format('Y-m-d')." +30 days"));
                                }

                                if ($this->Usuarios->save($participanteActual)){
                                    //mail($emailAlerta,"OK en Pago Dr Dieta","id: ".$participante_id.".");
                                    $nuevoPago->status = 'Aprobado';
                                } else{
                                    //mail($emailAlerta,"Error en Pago Dr Dieta","id: ".$participante_id.".");
                                    $nuevoPago->status = 'Con Error';
                                }
                                //Actualizo el pago en curso
                                @$this->Pagos->save($nuevoPago);
                            }
                        }
                    }


                    //El pago fue por renovar X meses
                    if($merchant_order_info["response"]["additional_info"] == "renovar3" OR $merchant_order_info["response"]["additional_info"] == "renovar6"){

                        //Para ver cuantos días sumarle
                        $diasRenovacion = 0;
                        if($merchant_order_info["response"]["additional_info"] == "renovar3")
                            $diasRenovacion = 90;
                        if($merchant_order_info["response"]["additional_info"] == "renovar6")
                            $diasRenovacion = 180;

                        $participante_id = $merchant_order_info["response"]["external_reference"];
                        if(!empty($participante_id)){
                            $participanteActual = $this->Usuarios->get($participante_id);
                            //Si el participante existe en la DB
                            if(!empty($participanteActual)){
                                $nuevoPago->participante_id = $participanteActual->id;
                                if(empty($participanteActual->licencia)){
                                    //Le sumo X días a la licencia desde hoy
                                    $participanteActual->licencia = date("Y-m-d", strtotime("+".$diasRenovacion." days"));
                                }else{
                                    //Le sumo X días a la licencia desde el vencimiento actual
                                    $participanteActual->licencia = date("Y-m-d", strtotime($participanteActual->licencia->format('Y-m-d')." +".$diasRenovacion." days"));
                                }

                                if ($this->Usuarios->save($participanteActual)){
                                    //mail($emailAlerta,"OK en Pago Dr Dieta","id: ".$participante_id.".");
                                    $nuevoPago->status = 'Aprobado';
                                } else{
                                    //mail($emailAlerta,"Error en Pago Dr Dieta","id: ".$participante_id.".");
                                    $nuevoPago->status = 'Con Error';
                                }
                                //Actualizo el pago aceptado
                                @$this->Pagos->save($nuevoPago);
                            }
                        }
                    }

                }
            }

        }
        
        echo "<br />Fin IPN";
        return;


    }

    public function wstienda(){
        
        $this->viewBuilder()->layout('ajax');
        $this->Tiendas = TableRegistry::get('Tiendas');


        echo "IPN Mercado Pago <br /><br />";
        $emailAlerta  = "julianbutti@gmail.com";

        $mp = new MP (CLIENT_ID, CLIENT_SECRET);

        if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
            http_response_code(400);
            return;
        }


        $topic = $_GET["topic"];
        $merchant_order_info = null;

        switch ($topic) {
            case 'payment':
                $payment_info = $mp->get("/collections/notifications/".$_GET["id"]);
                $merchant_order_info = $mp->get("/merchant_orders/".$payment_info["response"]["collection"]["merchant_order_id"]);
                break;
            case 'merchant_order':
                $merchant_order_info = $mp->get("/merchant_orders/".$_GET["id"]);
                break;
            default:
                $merchant_order_info = null;
        }


        if($merchant_order_info == null) {
            echo "Error obtaining the merchant_order";
            return;
        }

        if ($merchant_order_info["status"] == 200) {
            $transaction_amount_payments= 0;
            $transaction_amount_order = $merchant_order_info["response"]["total_amount"];
            $payments = $merchant_order_info["response"]["payments"];
            foreach ($payments as  $payment) {
                if($payment['status'] == 'approved'){
                    $transaction_amount_payments += $payment['transaction_amount'];
                }   
            }



            $bodyAdmin = serialize($merchant_order_info["response"]);
            //mail($emailAlerta, "Recibo un pago en MP" , $bodyAdmin);

            $carrito_id = $merchant_order_info["response"]["external_reference"];

            $carritoActual = $this->Tiendas->get($carrito_id);
            $carritoActual->datos = $bodyAdmin;
            $carritoActual->origen = 'MercadoPago';
            $carritoActual->status = 'Pendiente';
            $carritoActual->mp_id = $merchant_order_info["response"]["preference_id"];


            if($transaction_amount_payments >= $transaction_amount_order){
                
                //El pago fue por un carrito 
                if($merchant_order_info["response"]["additional_info"] == "carrito"){

                    if(!empty($carrito_id) AND !empty($carritoActual)){

                        $carritoActual->status = 'Aprobado';
                        @$this->Tiendas->save($carritoActual);
                        
                    }
                }
            }
        

        }
        
        echo "<br />Fin IPN";
        return;


    }

    
}