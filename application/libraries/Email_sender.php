<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_sender
{

    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('email');
    }

    public function send($to_email, $subject, $message)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.pullpick.com',
            'smtp_port' => 465,
            'smtp_user' => 'no-reply@pullpick.com',
            'smtp_pass' => 'bT&0j~_p)3%-',
            'smtp_crypto' => 'ssl',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );

        $this->CI->email->initialize($config);
        $this->CI->email->from('no-reply@pullpick.com', 'BMRI Pull Pick');
        $this->CI->email->to($to_email);
        $this->CI->email->subject($subject);
        $this->CI->email->message($message);

        if ($this->CI->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}
