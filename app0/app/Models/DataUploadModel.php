<?php

namespace App\Models;

use CodeIgniter\Model;

class DataUploadModel extends Model {

//protected $DBGroup = 'default';

    protected $table = 'data_upload';
    protected $primaryKey = 'id_upload';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    //protected $useSoftDeletes = true;
    protected $allowedFields = ['nama_file_ori', 'lokasi', 'timestamp'];
//protected $useTimestamps = true;
//    protected $createdField  = 'created_at';
//    protected $updatedField  = 'updated_at';
//    protected $deletedField  = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    // get all jobsite
    public function getDataUpload() {
        // tampilkan menggunakan query builder
        $builder = $this->builder();
        $query = $builder->get();
        return $query;
    }
    
    // insert data jobsite
    public function insertDataUpload($data) {
        $builder = $this->builder();
        // insert data
        return $builder->insert($data);
    }
    
    // delete Jobsite by ID
/*    public function delJobsite($no) {
        $builder = $this->builder();
        $builder->where('id', $no);
        return $builder->delete();
    } */

}