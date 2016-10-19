$(document).ready(function() {
   $('#btnsave').hide();
   $('#collectionDate').daterangepicker({
      singleDatePicker: true,
      calender_style: "picker_1",
      format:'D/M/YYYY'
   });
   // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
   $('form')
   .on('blur', 'input[required], input.optional, select.required', validator.checkField)
   .on('change', 'select.required', validator.checkField)
   .on('keypress', 'input[required][pattern]', validator.keypress);

   $('form').submit(function(e) {
      e.preventDefault();
      var submit = true;

      // evaluate the form using generic validaing
      if (!validator.checkAll($(this))) {
         submit = false;
      }

      if (submit)
      this.submit();

      return false;
   });

   <!-- /validator -->
   $(".department").select2({
      placeholder: "Pick a department",
      allowClear: true
   });
   $(".student").select2({
      placeholder: "Pick a student",
      allowClear: true
   });
   $(".semester").select2({
      placeholder: "Pick a semester",
      allowClear: true
   });
   $(".session").select2({
      placeholder: "Pick a session",
      allowClear: true
   });
   //get student lists
   $('#levelTerm').on('change',function (){
      var dept= $('#department_id').val();
      var session = $('#session').val();
      var semester = $(this).val();
      if(!dept || !session){
         new PNotify({
            title: 'Validation Error!',
            text: 'Please Pic A Department or Write session!',
            type: 'error',
            styling: 'bootstrap3'
         });
      }
      else {
         $.ajax({
            url:'/students/'+dept+'/'+session+'/'+semester,
            type: 'get',
            dataType: 'json',
            success: function(data) {
               //console.log(data);
               $('#students_id').empty();
               $('#students_id').append('<option  value="">Pic a Student</option>');
               $.each(data.students.data, function(key, value) {
                  $('#students_id').append('<option  value="'+value.id+'">'+value.name+'['+value.idNo+']</option>');

               });
               $(".student").select2({
                  placeholder: "Pick a Student",
                  allowClear: true
               });
            },
            error: function(data){
               errorManager(data);  }
            });
         }
      });
      //get fees lists
      $('#department_id').on('change',function(){
         var dept = $(this).val();
         $.ajax({
            url:'/fees-list/'+dept,
            type: 'get',
            dataType: 'json',
            success: function(data) {
               //console.log(data);
               $('#feeNames').empty();
               $('#feeNames').append('<option  value="">Pic a fee</option>');
               $.each(data.fees, function(key, value) {
                  $('#feeNames').append('<option  value="'+value.id+'">'+value.title+'</option>');

               });
               $(".fees").select2({
                  placeholder: "Pick a fee",
                  allowClear: true
               });
            },
            error: function(data){
               errorManager(data);
            }
         });
      });
      //get due amount
      $('#students_id').on('change',function(){
         var stdId = $(this).val();
         $.ajax({
            url:'/fees-getdue/'+stdId,
            type: 'get',
            dataType: 'json',
            success: function(data) {
               //console.log(data);
               $('#previousdue').val(data.due);
            },
            error: function(data){
               errorManager(data);
            }
         });
      });
      //get fee amount
      $('#feeNames').on('change',function(){
         var fid = $(this).val();
         $.ajax({
            url:'/fees/'+fid,
            type: 'get',
            dataType: 'json',
            success: function(data) {
               //console.log(data);
               $('#feeAmount').val(data.fee);
            },
            error: function(data){
               errorManager(data);
            }
         });
      });
      //add fee to grid
      $( "#btnAddRow" ).click(function() {
         if($('#feeNames').val() =="" || $('#fee').val() =="undefined"){
            var metaData={
               'message':{
                  'name':'Select fee first!',
                  'fee':'Fee amount missing!'
               }
            };
            var data = {
               'responseText':JSON.stringify(metaData)
            };
            errorManager(data);
         }
         else{
            var table = document.getElementById('feeList');
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            //total fee
            var totalFee=parseFloat($('#feeAmount').val());

            var cell1 = row.insertCell(0);
            var chkbox = document.createElement("input");
            chkbox.type = "checkbox";
            chkbox.checked=false;
            chkbox.name="sl["+rowCount+"]";
            cell1.appendChild(chkbox);

            var cell2 = row.insertCell(1);
            var title = document.createElement("lebel");
            title.innerHTML=$('#feeNames option:selected').text();
            cell2.appendChild(title);

            var hdtitle = document.createElement("input");
            hdtitle.name="fees["+rowCount+"]";
            hdtitle.value=$('#feeNames option:selected').text();
            hdtitle.type="hidden";
            cell2.appendChild(hdtitle);

            var cell3 = row.insertCell(2);
            var fee = document.createElement("lebel");
            fee.innerHTML=$('#feeAmount').val();
            cell3.appendChild(fee);

            var hdfee = document.createElement("input");
            hdfee.name="fee["+rowCount+"]";
            hdfee.value=$('#feeAmount').val();
            hdfee.type="hidden";
            cell3.appendChild(hdfee);


            //add to total fee below
            var ctotal= parseFloat($('#ctotal').val());

            $('#ctotal').val(ctotal+totalFee);
            grandTotal();
            btnSaveIsvisibale();
            //clear fee
            $('#feeNames').val("");
            $('#feeAmount').val("");
            $(".fees").select2({
               placeholder: "Pick a fee",
               allowClear: true
            });

         }
      });
      //remove fee to grid
      $( "#btnDeleteRow" ).click(function() {
         try {
            var table = document.getElementById("feeList");
            var rowCount = table.rows.length;
            var isAnyChecked=true;
            for(var i=0; i<rowCount; i++) {
               var row = table.rows[i];
               var chkbox = row.getElementsByTagName('input')[0];
               // console.log(chkbox);
               if(null != chkbox && true == chkbox.checked) {
                  var ftotal = parseFloat(row.getElementsByTagName('input')[2].value);
                  var ctotal= parseFloat($('#ctotal').val());
                  $('#ctotal').val(ctotal-ftotal);

                  table.deleteRow(i);
                  rowCount--;
                  i--;
                  grandTotal();
                  isAnyChecked=true;
               }
               else {
                  isAnyChecked=false;
               }
            }
            if(!isAnyChecked){
               new PNotify({
                  title: 'Error!',
                  text: 'Please check fee from list!',
                  type: 'error',
                  styling: 'bootstrap3'
               });
            }
            btnSaveIsvisibale();
         }catch(e) {
            alert(e);
         }
      });
      //total amount
      function grandTotal() {
         try {

            var gtotal = parseFloat($('#previousdue').val())+parseFloat($('#ctotal').val())+parseFloat($('#lateFee').val());
            $('#gtotal').val(gtotal);
            var paidamount =parseFloat($('#paidamount').val());
            var due = gtotal-paidamount;
            $('#dueamount').val(due);

         }
         catch (e) {
            // statements to handle any exceptions
            alert(e.message); // pass exception object to error handler
         }
      }
      //late fee amount change
      $('#lateFee').on('input change keyup paste mouseup propertychange', function() {
         grandTotal();
      });
      //paid amount change event
      $('#paidamount').on('input change keyup paste mouseup propertychange', function() {
         grandTotal();
      });
      //control submit button visibility
      function btnSaveIsvisibale()
      {
         var table = document.getElementById('feeList');
         var rowCount = table.rows.length;
         //console.log(rowCount);
         if(rowCount>1)
         $('#btnsave').show();
         else
         $('#btnsave').hide();
      }
      var errorManager = function(data){
         var respone = JSON.parse(data.responseText);
         $.each(respone.message, function( key, value ) {
            new PNotify({
               title: 'Error!',
               text: value,
               type: 'error',
               styling: 'bootstrap3'
            });
         });
      };
   });
