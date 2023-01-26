<?php
session_start();
if(isset($_SESSION['session_id']) && isset($_SESSION['admin'])){
    // $rownumber = mysqli_real_escape_string($conn, $_GET['rownum']);
    $rownumber = $_GET['rownum'];
    // echo $rownumber;
    // $count=0;
    $_row = '<tr id="row'.$rownumber.'">
            <td
            class="border-b border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium text-dark"
            >
                <input
                    required
                    type="text"
                    id="student'.$rownumber.'"
                    onkeyup="_admin_autocomplete('."'.inpu".$rownumber."'".');"
                    placeholder="Student Name"
                    class="inpu'.$rownumber.' w-full rounded-lg border-[1.5px] border-form-stroke py-3 px-5 font-medium text-body-color placeholder-body-color outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-[#F5F7FD]"
                />
            </td>
            <td
            class="border-b border-[#E8E8E8] bg-[#F3F6FF] py-5 px-2 text-center text-base font-medium text-dark"
            >
                <input
                    required
                    type="text"
                    id="email'.$rownumber.'"
                    onkeyup="_admin_autocomplete('."'.einpu".$rownumber."'".');"
                    placeholder="Student Email"
                    class="einpu'.$rownumber.' w-full rounded-lg border-[1.5px] border-form-stroke py-3 px-5 font-medium text-body-color placeholder-body-color outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-[#F5F7FD]"
                />
            </td>
            <td
            class="border-b border-r border-[#E8E8E8] bg-white py-5 px-2 text-center text-base font-medium text-dark"
            >
            <a
                onclick=remove_row("row'.$rownumber.'")
                href="javascript:void(0)"
                class="inline-block rounded border border-primary py-2 px-6 text-primary hover:bg-primary hover:text-white"
            >
                Remove
            </a>
            </td>
    </tr>';
    echo json_encode(["result"=>"success", "data"=>$_row]);
    exit();
}
echo json_encode(["result"=>"error", "message"=>"not loggedin"]);
exit();
?>