function clickCheckList1()
{
    if($('#checkboxSuccess5').is(":checked"))
    {
        $('#checkboxSuccess6').prop('disabled',false);
        $('#checkboxSuccess7').prop('disabled',false);
        $('#checkboxSuccess8').prop('disabled',false);
    }
    else
    {
        $('#checkboxSuccess6').prop('disabled',true);
        $('#checkboxSuccess7').prop('disabled',true);
        $('#checkboxSuccess8').prop('disabled',true);
        $('#checkboxSuccess6').prop('checked', false);
        $('#checkboxSuccess7').prop('checked', false);
        $('#checkboxSuccess8').prop('checked', false);
    }
}
function clickCheckList2()
{
    if($('#checkboxSuccess1').is(":checked"))
    {
        $('#checkboxSuccess2').prop('disabled',false);
        $('#checkboxSuccess3').prop('disabled',false);
        $('#checkboxSuccess4').prop('disabled',false);
    }
    else
    {
        $('#checkboxSuccess2').prop('disabled',true);
        $('#checkboxSuccess3').prop('disabled',true);
        $('#checkboxSuccess4').prop('disabled',true);
        $('#checkboxSuccess2').prop('checked', false);
        $('#checkboxSuccess3').prop('checked', false);
        $('#checkboxSuccess4').prop('checked', false);
    }
}

function clickCheckList3()
{
    if($('#checkboxSuccess9').is(":checked"))
    {
        $('#checkboxSuccess10').prop('disabled',false);
        $('#checkboxSuccess11').prop('disabled',false);
        $('#checkboxSuccess12').prop('disabled',false);
    }
    else
    {
        $('#checkboxSuccess10').prop('disabled',true);
        $('#checkboxSuccess11').prop('disabled',true);
        $('#checkboxSuccess12').prop('disabled',true);
        $('#checkboxSuccess10').prop('checked', false);
        $('#checkboxSuccess11').prop('checked', false);
        $('#checkboxSuccess12').prop('checked', false);
    }
}

function clickCheckList4()
{
    if($('#checkboxSuccess13').is(":checked"))
    {
        $('#checkboxSuccess14').prop('disabled',false);
        $('#checkboxSuccess15').prop('disabled',false);
        $('#checkboxSuccess16').prop('disabled',false);
    }
    else
    {
        $('#checkboxSuccess14').prop('disabled',true);
        $('#checkboxSuccess15').prop('disabled',true);
        $('#checkboxSuccess16').prop('disabled',true);
        $('#checkboxSuccess14').prop('checked', false);
        $('#checkboxSuccess15').prop('checked', false);
        $('#checkboxSuccess16').prop('checked', false);
    }
}

function clickCheckList5()
{
    if($('#checkboxSuccess17').is(":checked"))
    {
        $('#checkboxSuccess18').prop('disabled',false);
        $('#checkboxSuccess19').prop('disabled',false);
        $('#checkboxSuccess20').prop('disabled',false);
    }
    else
    {
        $('#checkboxSuccess18').prop('disabled',true);
        $('#checkboxSuccess19').prop('disabled',true);
        $('#checkboxSuccess20').prop('disabled',true);
        $('#checkboxSuccess18').prop('checked', false);
        $('#checkboxSuccess19').prop('checked', false);
        $('#checkboxSuccess20').prop('checked', false);
    }
}

function clickCheckList6()
{
    if($('#checkboxSuccess21').is(":checked"))
    {
        $('#checkboxSuccess22').prop('disabled',false);
        $('#checkboxSuccess23').prop('disabled',false);
        $('#checkboxSuccess24').prop('disabled',false);
    }
    else
    {
        $('#checkboxSuccess22').prop('disabled',true);
        $('#checkboxSuccess23').prop('disabled',true);
        $('#checkboxSuccess24').prop('disabled',true);
        $('#checkboxSuccess22').prop('checked', false);
        $('#checkboxSuccess23').prop('checked', false);
        $('#checkboxSuccess24').prop('checked', false);
    }
}
function clickCheckList7()
{
    if($('#checkboxSuccess25').is(":checked"))
    {
        $('#checkboxSuccess26').prop('disabled',false);
        $('#checkboxSuccess27').prop('disabled',false);
        $('#checkboxSuccess28').prop('disabled',false);
    }
    else
    {
        $('#checkboxSuccess26').prop('disabled',true);
        $('#checkboxSuccess27').prop('disabled',true);
        $('#checkboxSuccess28').prop('disabled',true);
        $('#checkboxSuccess26').prop('checked', false);
        $('#checkboxSuccess27').prop('checked', false);
        $('#checkboxSuccess28').prop('checked', false);
    }
}
clickCheckList1();
clickCheckList2();
clickCheckList3();
clickCheckList4();
clickCheckList5();
clickCheckList6();
clickCheckList7();
$("body").on("click","#checkboxSuccess1",function(){
    clickCheckList2();
});
$("body").on("click","#checkboxSuccess5",function(){
    clickCheckList1();
});
$("body").on("click","#checkboxSuccess9",function(){
    clickCheckList3();
});
$("body").on("click","#checkboxSuccess13",function(){
    clickCheckList4();
});
$("body").on("click","#checkboxSuccess17",function(){
    clickCheckList5();
});
$("body").on("click","#checkboxSuccess21",function(){
    clickCheckList6();
});
$("body").on("click","#checkboxSuccess25",function(){
    clickCheckList7();
});