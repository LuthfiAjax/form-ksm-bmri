<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Restfull extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('layout/header');
        $this->load->view('welcome');
        $this->load->view('layout/footer');
    }

    public function success()
    {
        $this->load->view('success');
    }

    public function get_cabang()
    {
        header("Access-Control-Allow-Origin: *");

        $query = $this->db->select('KD_CABANG, NAMA_CABANG, AREA, REGION')->group_by('KD_CABANG')->get('tb_cabang')->result_array();
        if ($query) {
            header("Content-Type: application/json");
            echo json_encode($query);
        } else {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(["message" => "Data not found"]);
        }
    }

    public function get_result_cabang($key)
    {
        header("Access-Control-Allow-Origin: *");

        $query = $this->db->select('NAMA_K_L')->where('KD_CABANG', $key)->group_by('NAMA_K_L')->get('tb_cabang')->result_array();

        if ($query) {
            header("Content-Type: application/json");
            echo json_encode($query);
        } else {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(["message" => "Data not found"]);
        }
    }

    public function search_kl($kd)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        $key = $this->input->post('keyword');

        $query = $this->db->select('NAMA_NASABAH, SUM(COUNT_CIF) as COUNT_CIF, SUM(INDIKATIF) as INDIKATIF')->group_by('NAMA_NASABAH')->where('KD_CABANG', $kd)->like('NAMA_K_L', $key)->get('tb_cabang')->result_array();

        if ($query) {
            // Mengubah format angka INDIKATIF menjadi format rupiah
            foreach ($query as &$row) {
                $row['INDIKATIF'] = 'Rp. ' . number_format($row['INDIKATIF'], 0, ',', '.');
            }

            header("Content-Type: application/json");
            echo json_encode($query);
        } else {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(["message" => "Data not found"]);
        }
    }

    public function reporting()
    {
        $kodecabang = $this->input->post('cabang');
        $namacabang = $this->input->post('namacabang');
        $areacabang = $this->input->post('areacabang');
        $regioncabang = $this->input->post('regioncabang');
        $kelolaanselect = $this->input->post('kelolaanselect');
        $satker = $this->input->post('satker');
        $leadscabang = $this->input->post('leadscabang');
        $indikatifcabang = $this->input->post('indikatifcabang');
        $namanasabah = $this->input->post('namanasabah');
        $jabatannasabah = $this->input->post('jabatannasabah');
        $nomorhpnasabah = $this->input->post('nomorhpnasabah');
        $minat = $this->input->post('minat');
        $namapic = $this->input->post('namapic');
        $jabatanpic = $this->input->post('jabatanpic');

        $melalui = $this->input->post('melalui') ?: 'N/A';
        $alasan = $this->input->post('alasan') ?: 'N/A';

        $bukti = $_FILES['bukti']['name'];
        $dokumentasi = isset($_FILES['dokumentasi']['name']) ? $_FILES['dokumentasi']['name'] : null;

        $config['encrypt_name'] = TRUE;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|heif|hevc|webp';
        $config['max_size'] = '5120';
        $config['upload_path'] = 'assets/doc/';
        $config['file_ext_tolower'] = TRUE;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('bukti')) {
            $img = $this->upload->data();
            $bukti = $img['file_name'];

            $image_path = $config['upload_path'] . $img['file_name'];
            $this->reduce_image_quality($image_path, 80);
        } else {
            $bukti = null;
        }

        if ($this->upload->do_upload('dokumentasi')) {
            $img_dok = $this->upload->data();
            $dokumentasi = base_url('assets/doc/') . $img_dok['file_name'];

            $image_path_dok = $config['upload_path'] . $img_dok['file_name'];
            $this->reduce_image_quality($image_path_dok, 80);
        } else {
            $dokumentasi = 'N/A';
        }


        $data = array(
            'KD_CABANG' => $kodecabang,
            'NM_CABANG' => $namacabang,
            'AREA' => $areacabang,
            'REGION' => $regioncabang,
            'NM_KELOLAAN' => $kelolaanselect,
            'SATKER' => $satker,
            'LEADS' => $leadscabang,
            'LIMIT_INDIKATIF' => $indikatifcabang,
            'NM_NASABAH' => $namanasabah,
            'JABATAN_NASABAH' => $jabatannasabah,
            'NO_HP_NASABAH' => $nomorhpnasabah,
            'STATUS_BERMINAT' => $minat,
            'BERMINAT_APLIKASI_MELALUI' => $melalui,
            'DOKUMENTASI_KUNJUNGAN' =>  $dokumentasi,
            'BLM_BERMINAT_ALASAN' => $alasan,
            'NAMA_PIC' => $namapic,
            'JABATAN_PIC' => $jabatanpic,
            'BUKTI_KUNJUNGAN' => base_url('assets/doc/') . $bukti
        );

        $json_data = json_encode($data);
        $api_url = 'https://script.google.com/macros/s/AKfycbwh84CMGMB6jOuWewhclRvYhYzTXtcz-K9F0TMcG2lgy-RnfLtqMfay1erTJVLJoCs/exec';

        $options = array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_POSTFIELDS => $json_data
        );

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        if (!$response) {
            echo 'Error: ' . curl_error($curl);
        } else {
            redirect(base_url('success'));
        }
        curl_close($curl);
    }


    function reduce_image_quality($image_path, $quality)
    {
        $image_info = getimagesize($image_path);
        $mime_type = $image_info['mime'];

        switch ($mime_type) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($image_path);
                break;
            case 'image/png':
                $image = imagecreatefrompng($image_path);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($image_path);
                break;
            default:
                return;
        }

        imagejpeg($image, $image_path, $quality);
        imagedestroy($image);
    }
}
