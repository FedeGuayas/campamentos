<?php
/**
 * Clase con la logica para crear los codigos de activacion y enviar correos
 *
 * Created by PhpStorm.
 * User: halain
 * Date: 26-Sep-16
 * Time: 10:51:45 PM
 */

namespace App;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class ActivationService
{

    protected $mailer;

    protected $activationRepo;

    protected $resendAfter = 24;

    public function __construct(Mailer $mailer, ActivationRepository $activationRepo)
    {
        $this->mailer = $mailer;
        $this->activationRepo = $activationRepo;
    }

    //Metodo para enviar el correo de activacion
    public function sendActivationMail($user)
    {

        if ($user->activated || !$this->shouldSend($user)) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);

        $link = route('user.activate', $token);
        $message = sprintf('Activate account <a href="%s">%s</a>', $link, $link);

        //cambiando raw por send se puede utilizar una plantilla html para el mail
        $this->mailer->raw($message, function (Message $m) use ($user) {
            $m->to($user->email)->subject('Activation mail');
        });


    }

    //Metodo para activar al usuario
    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        $user = User::find($activation->user_id);

        $user->activated = true;
        $role=Role::where('name', 'register')->first();
        $user->attachRole($role);
        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;

    }

    //Metodo para chequear si el email ha sido enviado recientemente
    private function shouldSend($user)
    {
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }


}