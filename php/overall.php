<?php
require_once '_db.php';
session_start();
// print_r($_SESSION);
if(isset($_SESSION['session_id']) && $_SESSION['admin'] == 1){
        // print_r($_POST);
        $_teamno = $_POST['teamno'];
        function _table_row($ranks){
            $_rank = explode(',',$ranks);
            $_td = '';
            for($i =0; $i<sizeof($_rank);$i++)
            {
                $_td .= '<td class="text-center border-r-2 p-3 hover:bg-primary hover:text-white">'.$_rank[$i].'</td>';
            }
            return $_td;
        }
        function _table_name($_persons){
            $_person = explode(',', $_persons);
            $_th = '';
            for($i = 0; $i<sizeof($_person); $i++)
            {
                $_th .= '<th class="text-center border-r-2 p-3">'.$_person[$i].'</th>';
            }
            return $_th;
        }

        $_person='';
        $sno=0;
        $_perosn_ranked=0;
        $_table_data='';
        $_sql = "SELECT * FROM student WHERE teamno = '{$_teamno}'";
        $result = mysqli_query($conn, $_sql);

        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                $_person =_table_name($row["rank_by"]);
                

                // $_rank .='<td class="text-center border-r-2">2</td>';
                $_table_data .= '<tr class="border-b border-r border-[#E8E8E8] rounded-lg p-3 hover:bg-primary hover:bg-opacity-10">
                    <td class="text-center border-r-2 p-3 hover:bg-primary rounded-lg hover:text-white"> '.++$sno.' </td>
                    <td class="text-center border-r-2 hover:bg-primary rounded-lg hover:text-white"> '.$row["full_name"].' </td>
                    '._table_row($row["ranks"]).'
                    
                    <td class="text-center border-r-2 p-3 rounded-lg hover:bg-primary hover:text-white">'.$row['total'].'</td>
                    <td class="text-center border-r-2 p-3 rounded-lg hover:bg-primary hover:text-white">'.$row['rank'].'</td>
                    <td class="text-center border-r-2 p-3 rounded-lg hover:bg-primary hover:text-white">'.$row['marks'].'</td>
                    </tr>';
                    $_perosn_ranked = sizeof(explode(',', $row["ranks"]));
            }
            $_head = '<tr class="bg-primary text-center" id="head">
                <th
                    colspan="2"
                class="w-1/6 min-w-[160px] border-r-2 py-4 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4"
                >
                Student'."'".'s Name
                </th>
                <th
                    colspan="'.$_perosn_ranked.'"
                class="w-1/6 min-w-[160px] py-4 border-r-2 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4"
                >
                Who Ranked
                </th>
                <th
                class="w-1/6 min-w-[160px] py-4 border-r-2 px-3 text-lg font-semibold text-white lg:py-7 lg:px-4"
                >
                Total
                </th>
                <th
                class="w-1/6 min-w-[160px] py-4 px-3 border-r-2 text-lg font-semibold text-white lg:py-7 lg:px-4"
                >
                Rank
                </th>
                <th
                class="w-1/6 min-w-[160px] py-4 px-3 text-lg border-r-2 font-semibold text-white lg:py-7 lg:px-4"
                >
                Marks
                </th>
            </tr>';
            
            $_subhead='<tr class="bg-black text-white" id="sub-head">
            <th class="text-center border-r-2 p-3">    </th>
            <th class="text-center border-r-2 p-3">    </th>
            '.$_person.'
            <th class="text-center border-r-2 p-3"></th>
            <th class="text-center border-r-2 p-3"></th>
            <th class="text-center border-r-2 p-3"></th>
            </tr>';
        }else{
            $_head='No data found';
            $_subhead='No data found';
            $_table_data = 'No data found';
        }
        echo json_encode(["head"=>$_head, "sub_head"=>$_subhead, "table_data"=>$_table_data]);
        exit();
    }
    echo json_encode(["result"=>"error", "message"=>"not logged in"]);
    exit();
?>