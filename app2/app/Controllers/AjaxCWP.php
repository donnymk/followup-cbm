<?php

namespace App\Controllers;

use App\Models\PopulasiModel;
use App\Models\CWPModel;

class AjaxCWP extends BaseController {

    public function index() {
        echo 'hai';
    }

    // get data CWP
    public function data_cwp() {
        // initialize the session
        $session = \Config\Services::session();

        // cek session login untuk mengetahui role access
//        if ($session->has('username')) {
//            $role = $session->role;
//        }        

        $data_cwp = [];

        // Check for AJAX request
        if ($this->request->isAJAX()) {
            // QUERY MELALUI MODEL
            $model = new CWPModel();
            $get_data_cwp = $model->getDataCWP();

            foreach ($get_data_cwp as $key => $value):

                // button action
                $exportpdf_button = '<a class="btn btn-primary" href="cetak_form/' . $value->id . '" title="Export PDF" target="_blank"><span class="fa fa-2x fa-file-pdf"></span></a>';
                $update_button = '<a class="btn btn-secondary btn-sm" href="update/' . $value->id . '" title="Detail dan Edit data"><span class="fa fa-2x fa-info"></span></a>';
                $delete_button = '<a class="btn btn-secondary btn-sm" href="delete_cwp/' . $value->id . '" title="Hapus" onclick="return confirm_del(' . $value->id . ')"><span class="fa fa-trash"></span></a>';

                // leadtime warranty = closing date - claim date
                $claim_date = date_create($value->claim_date);
                $closing_date = date_create($value->closing_date);
                $diff = date_diff($claim_date, $closing_date);
                $leadtime_warranty = $diff->format("%R%a");
                if($value->closing_date == '0000-00-00' || $value->closing_date == ''){
                    $leadtime_warranty = null;
                }

                array_push($data_cwp,
                        array($exportpdf_button . $update_button . $delete_button,
                            $value->id,
                            $value->jobsite,
                            $value->claim_date,
                            $value->claim_to,
                            //$value->brand_unit,
                            $value->model_unit,
                            $value->code_unit,
                            //$value->sn_unit,
                            //$value->major_component,
                            //$value->sn_component,
                            //$value->status_unit,
                            //$value->schedule_folow_up,
                            $value->component,
                            $value->sub_component,
                            $value->fitment_date,
                            $value->{'hm/km_fitment'},
                            $value->trouble_date,
                            $value->{'hm/km_trouble'},
                            $value->lifetime,
                            $value->problem_issue,
                            $value->supporting_comments,
                            $value->part_number,
                            $value->qty,
                            $value->amount_part,
                            $value->warranty_decision,
                            $value->final_amount,
                            $value->closing_date,
                            $value->remark_progress,
                            $leadtime_warranty
                        )
                );
            endforeach;

            $json_data = array(
                "data" => $data_cwp
            );
            echo json_encode($json_data);
        }
        return false;
    }

    // get model unit berdasarkan brand unit
    public function get_model_unit() {
        $data_model_unit = [];

        // data dari Ajax request
        $brandUnit = $this->request->getVar('brandUnit');

        // Check for AJAX request
        if ($this->request->isAJAX()) {

            // QUERY MELALUI MODEL
            $model = new PopulasiModel();
            $get_model_unit = $model->getModelUnitbyBrandUnit($brandUnit);

            foreach ($get_model_unit as $key => $value):
                array_push($data_model_unit, $value->model_unit);
            endforeach;
        }

        echo json_encode($data_model_unit);
    }

    // get code unit berdasarkan model unit
    public function get_code_unit() {
        $data_code_unit = [];

        // data dari Ajax request
        $modelUnit = $this->request->getVar('modelUnit');

        // Check for AJAX request
        if ($this->request->isAJAX()) {

            // QUERY MELALUI MODEL
            $model = new PopulasiModel();
            $get_code_unit = $model->getCodeUnitbyModelUnit($modelUnit);

            foreach ($get_code_unit as $key => $value):
                array_push($data_code_unit, $value->code_unit);
            endforeach;
        }

        echo json_encode($data_code_unit);
    }

    // get jumlah Claim Warranty Proposal berdasarkan status
    public function count_cwp() {
        // Check for AJAX request
        if ($this->request->isAJAX()) {
            // QUERY MELALUI MODEL
            $model = new CWPModel();
            //$get_data_cwp = $model->getdataCbm();
            $get_count_cwp = $model->countCWPByJobsite('All');

            echo json_encode($get_count_cwp);
        }
        return false;
    }

}
