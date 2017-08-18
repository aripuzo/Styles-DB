<?php

/**
 * Description of StoreCreditRepository
 *
 * @author olaar
 */

namespace App\Repository\Contracts;

interface DesignerRepository {
    //put your code here
    function searchName($name);
    function getDesigner($id);

}
