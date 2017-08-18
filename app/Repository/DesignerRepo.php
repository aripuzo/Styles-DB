<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StoreCreditRepository
 *
 * @author olaar
 */
namespace App\Repository;

use App\Models\Designer;
use App\Repository\Contracts\DesignerRepository;

class DesignerRepo implements DesignerRepository{ // all deletes should be soft delete
    //put your code here

    function searchName($name){
        $terms = Designer::where('name', 'like', '%' . $name . '%')
        					->pluck('name')
                			->toArray();
        return array_unique($terms);
    }

    function getDesigner($id){
        
    }
}
