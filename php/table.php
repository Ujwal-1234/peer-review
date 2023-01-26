<?php
    require_once '_db.php';
    session_start();
    if(isset($_SESSION['session_id'])){
        if($_SESSION['admin']==1){
            echo json_encode(["result"=>"error", "message"=>"admin_user"]);exit();
        }
        $_rowdata = [];
        $_tabledata ='';
        $email = $_SESSION['session_id'];
        $sql = mysqli_query($conn, "SELECT * FROM student WHERE teamno = (SELECT teamno FROM student WHERE email = '{$email}')");
        if(mysqli_num_rows($sql) > 0){
            // echo mysqli_num_rows($sql);
            $_count=0;
            $_showsno=0;
            $_sno = 0;
            while ($row = mysqli_fetch_assoc($sql)){
                $_limit_date = $row['timelimit'];
                $_ranked_person = $row['rank_by'];
                $_list_ranked_person = explode(',', $_ranked_person);
                for($_loop=0; $_loop < sizeof($_list_ranked_person); $_loop++)
                {
                    if( $_SESSION['session_id'] == $_list_ranked_person[$_loop])
                    {
                        echo json_encode(["result"=>"warning", "message"=>"already ranked"]);exit();
                    }
                }
                if($row['email']==$_SESSION['session_id']){
                    $_sno++;
                    $_rowdata[++$_count] = $row;
                    $_tabledata .= '<tr hidden>
                        <td
                        class="border-b border-l border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium text-dark"
                        >
                        '.$_showsno.'
                        </td>
                        <td
                        class="border-b border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium text-dark"
                        >
                        '.$_rowdata[$_count]["full_name"].'
                        <input type="text" class="p-3" name= "email'.$_sno.'" value="'.$row['email'].'" placeholder="email" hidden>
                        </td>
                        <td
                        class="border-b border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium text-dark"
                        >
                        <input type="text" class="p-3" name= "input'.$_sno.'" value="0" placeholder="input Rank">
                        </td>
                        
                
                    </tr>';
                }else{
                    $_sno++;
                    $_rowdata[++$_count] = $row;
                    $_tabledata .= '<tr>
                    <td
                    class="border-b border-l border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium text-dark"
                    >
                    '.++$_showsno.'
                    </td>
                    <td
                    class="border-b border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium text-dark"
                    >
                    '.$_rowdata[$_count]["full_name"].'
                    <input type="text" class="p-3" name= "email'.$_sno.'" value="'.$row['email'].'" placeholder="email" hidden>
                    </td>
                    <td
                    class="border-b border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium text-dark"
                    >
                    <input type="text" class="p-3" name= "input'.$_sno.'" value="0" placeholder="input Rank">
                    </td>
                    
                    </tr>
                    ';
                }
            }
            $_SESSION['teamno']=$_sno;
            // print_r($_rowdata);

            echo json_encode(["result"=>"success", "date_limit"=>$_limit_date, "team_no"=>$_rowdata[1]['teamno'], "data"=>$_tabledata, "session_data"=>$_SESSION, "type"=>"S"]);exit();
        }
        echo json_encode(["result"=>"warning", "message"=>"Not part of any team"]);exit();
    }
    else{
        echo json_encode(["result"=>"error", "message"=>"not logged in"]);exit();
    }
?>