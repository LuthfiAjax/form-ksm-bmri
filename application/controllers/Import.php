<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

use PhpOffice\PhpSpreadsheet\IOFactory;

class Import extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->library('email_sender');
    }

    public function getExcel()
    {
        $this->load->view('getExcel');
    }

    public function importExcel()
    {
        $kode = $this->input->post('kode');
        $excel = $_FILES['excel']['name'];

        $cekkode = $this->db->get_where('tb_kode', ['value_code' => $kode])->row();

        if ($cekkode && time() < $cekkode->expired_code) {
            $config['upload_path'] = './assets/excel/';
            $config['allowed_types'] = 'xlsx|xls';
            $config['max_size'] = 20480; // 20 MB

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('excel')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                redirect(base_url('update-data'));
            }

            $file_data = $this->upload->data();
            $file_path = './assets/excel/' . $file_data['file_name'];

            $spreadsheet = IOFactory::load($file_path);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();

            if (empty($data)) {
                $this->session->set_flashdata('error', 'Tidak ada data');
                redirect(base_url('update-data'));
            }

            $emty_tb = $this->db->truncate('tb_cabang');

            if (!$emty_tb) {
                $this->session->set_flashdata('error', 'Data Tidak Berhasil Dihapus');
                redirect(base_url('update-data'));
            }

            array_shift($data);

            foreach ($data as $row) {
                if (isset($row[0]) && isset($row[1])) {
                    $kd_cabang = $row[0];
                    $nama_cabang = $row[1];
                    $area = $row[2];
                    $region = $row[3];
                    $nama_k_l = $row[4];
                    $nama_nasabah = $row[5];
                    $count_cif = trim($row[6], ' ,');
                    $indikatif = trim($row[7], ' ,');

                    $insert_data = [
                        'KD_CABANG' => $kd_cabang,
                        'NAMA_CABANG' => $nama_cabang,
                        'AREA' => $area,
                        'REGION' => $region,
                        'NAMA_K_L' => $nama_k_l,
                        'NAMA_NASABAH' => $nama_nasabah,
                        'COUNT_CIF' => $count_cif,
                        'INDIKATIF' => $indikatif
                    ];

                    $this->db->insert('tb_cabang', $insert_data);
                }
            }

            $tempfile = unlink(FCPATH . 'assets/excel/' . $file_data['file_name']);
            if ($tempfile) {
                $send_remmender = $this->send_remender();
            }

            redirect(base_url('update-data'));
        } else {
            $this->session->set_flashdata('error', 'Code is wrong or expired!');
            redirect(base_url('update-data'));
        }
    }

    public function batal($kode)
    {
        $blog = $this->db->delete('tb_kode', ['value_code' => $kode]);
        if ($blog) {
            $this->session->set_flashdata('message', 'Kode Berhasil di Hapus');
            redirect(base_url('update-data'));
        }
    }

    public function send_kode()
    {
        $randomCode = $this->generateRandomCode(15);

        $key = $this->input->post('key');
        $users = $this->db->get('tb_email')->result_array();

        if ($users) {
            $send_mail = false;

            foreach ($users as $user) {
                $message = '
                <h3>Halo, ' . $user['nama_email'] . '</h3>
                <p>Berikut adalah kode konfirmasi untuk memperbarui data Form KSM : <b> ' . $randomCode . ' </b></p>
                <p>Kode ini berlaku selama 5 menit.</p>
                <p>Jika Anda tidak ingin memperbarui data, silakan klik tombol di bawah ini : <br> </p>
                <p><a href="' . base_url('batal/' . $randomCode) . '" target="_blank" style="color: #007bff; text-decoration: none; border: 1px solid #007bff; padding: 5px 10px; border-radius: 5px;">Batalkan</a></p> 
                <p><br> <small>Catatan: Pembatalan hanya dapat dilakukan sebelum file diunggah atau dalam waktu 5 menit setelah anda menerima pesan ini.</small></p>        
            ';
                $subject = 'Kode Konfirmasi Form KSM - BMRI';
                $to_email = $user['value_email'];

                $send_mail = $this->email_sender->send($to_email, $subject, $message);
            }

            if ($send_mail) {
                $data = [
                    'value_code' => $randomCode,
                    'expired_code' => time() + (60 * 60 * 5)
                ];
                $this->db->insert('tb_kode', $data);

                $time_old = time() - (60 * 60 * 5);
                $this->db->where('expired_code <', $time_old)->delete('tb_kode');

                $response = array(
                    'status' => 'success',
                    'message' => 'Emails with codes have been sent.'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Send Code Error'
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'No accounts found.'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    private function send_remender()
    {
        $users = $this->db->get('tb_email')->result_array();
        if ($users) {
            $send_mail = false;

            foreach ($users as $user) {
                $message = '
                    <h3>Halo, ' . $user['nama_email'] . '</h3>
                    <p>Data Form KSM Anda telah berhasil diperbarui pada tanggal ' . date('d/m/Y H:i') . '.</p>
                    <p>Perbaruan ini akan membantu kami memastikan data yang akurat dan up-to-date.</p>
                    <p>Terima kasih atas kerjasama Anda!</p>
                ';
                $subject = 'Data Form KSM Berhasil Terupdate - BMRI';
                $to_email = $user['value_email'];

                $send_mail = $this->email_sender->send($to_email, $subject, $message);
            }

            return $this->session->set_flashdata('message', 'Import Data Berhasil');
        } else {
            return $this->session->set_flashdata('message', 'Import Data Berhasil');
        }
    }

    public function generateRandomCode($length)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        $charactersLength = strlen($characters);

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }

        return $code;
    }
}
