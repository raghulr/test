<?php   header('Content-Type: application/json');
        $paginationParams = $this->Paginator->params();
        $response['Page']['currentPage'] = $paginationParams['page'];
        $response['Page']['totalPage'] = $paginationParams['pageCount'];
        if($paginationParams['nextPage'] == true)
            $response['Page']['nextPage'] = $paginationParams['page']+1;
        echo json_encode($response);?>