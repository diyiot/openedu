
//var DATA; 
//var API = "http://127.0.0.1/";   
//indexconfig.js
$(document).ready(function() {
    $("#opendata").attr("href", OPENDATA);
    $('#el-idrima').attr("disabled", true);
    $('#el-sxolh').attr("disabled", true);
    $('#el-ereunitiko').attr("disabled", true);
    $('#el-institute').attr("disabled", true);
    $('#el-other').attr("disabled", true);

    $('label[for="el-ereunitiko"]').attr("disabled", true);
    $('label[for="el-institute"]').attr("disabled", true);
    $('label[for="el-other"]').attr("disabled", true);
    $('label[for="el-idrima"]').attr("disabled", true);
    $('label[for="el-sxolh"]').attr("disabled", true);
    var NEWSELECT='';

$('#newselect').on('change', function () {
    var newselect = $("#newselect option").filter(":selected").text();
    if(newselect == 'Διοικητικό Προσωπικό'){
        $('#el-sxolh').attr("disabled", true);
	$('#tmimaerg').empty();
	$('#tmimaerg1').empty();
        NEWSELECT = 'dioikitiko';
    }else if(newselect == 'Μεταπτυχιακός φοιτητής'){
        $('#el-sxolh').attr("disabled", true);
	$('#tmimaerg').empty();
	$('#tmimaerg1').empty();
	$('#tmimaerg').append(tmimaerg);
        NEWSELECT = 'meta';
    }else{
	$('#tmimaerg').empty();
	$('#tmimaerg1').empty();
	$('#tmimaerg').append(tmimaerg);
        NEWSELECT = 'allo';
    }
    $.ajax({
        url: API+'uni',
        type: 'GET',
        dataType: 'json',
    	success: function (data, statusText, resObject) {
		var key = this.value;
		$('#el-idrima').prop("disabled", false); 
		$('#el-idrima').empty();
		$('#el-sxolh').empty();
		$('#eltmhmalession').empty();
		$('#el-idrima').append($("<option></option>")
				                    .attr("value", '')
				                    .text('Ίδρυμα'));
       		$.each(data.result.data, function(index, d){            

				$('#el-idrima').append($("<option></option>")
				                    .attr("value", d.id)
				                    .text(d.name));
		});
   	}
    });
});

$('#el-idrima').on('change', function () {
    var key = this.value;
    var uni = $("#el-idrima option").filter(":selected").text();
    var unival = $("#el-idrima option").filter(":selected").val();
    var unitmp = unival.substring(0,1);
	if(NEWSELECT == 'dioikitiko'){
		$('#eltmhmalession').empty();
		$('#eltmhmalession').append(tmimaselecturl);
		$('#add_field_button').remove();
		$('.del_field_button_url').remove();
	//}else if(NEWSELECT == 'meta'){
		//$('#eltmhmalession').empty();
		//$('#eltmhmalession').append(tmimaselecturlmeta);
		//$('#add_field_button').remove();
		//$('#eltmhmalessionadd').prepend(tmimaselect1);
		//$('#add_field_button').remove();
	}else if(unitmp == 'e'){
		$('#eltmhmalession').empty();
		$('#eltmhmalession').append(tmimaselecturl);
		$('#add_field_button').remove();
		$('.del_field_button_url').remove();
	//}else if(unitmp == 'i'){
		//$('#eltmhmalession').empty();
		//$('#eltmhmalession').append(tmimaselecturlmeta1);
		//$('#add_field_button').remove();
		//$('#eltmhmalessionadd').prepend(tmimaselect1);
	}else{
	    $.ajax({
		url: API+'department',
		type: 'GET',
		data:{"department":uni},
		dataType: 'json',
		success: function (data, statusText, resObject) {
			$('#el-sxolh').prop("disabled", false); 
			$('#el-sxolh').empty();
			$('#eltmhmalession').empty();
			$('#el-sxolh').append($("<option></option>").attr("value", '').text('Τμήμα'));
			$.each(data.result.data, function(index, d){            
				$('#el-sxolh').append($("<option></option>")
						    .attr("value", d.id)
						    .text(d.department));
			});
	    }
	  });
	}
});

var tmimaselect = '<div class="eltimagroup">';
tmimaselect +='<label class="bg-info control-label hidden-xs hidden-sm col-md-3 required" for="el-mathima">Μάθημα/Εργαστήριο</label>';
tmimaselect +='<div class="col-xs-12 col-sm-12 col-md-9">';
tmimaselect +='<select class="form-control input-sm eltmima" data-placeholder="Τμήμα" required name="mathima">';
tmimaselect +='<option selected=""  value="">Μάθημα/Εργαστήριο</option>';
tmimaselect +='<option value="1"></option>';
tmimaselect +='</select>';
tmimaselect +='</div>';

tmimaselect +='<label class="control-label required hidden-xs hidden-sm col-md-3" for="el-mathimatechnologia">Ανοιχτή Τεχνολογία </label>';
tmimaselect +='<div class="col-xs-12 col-sm-12 col-md-9">';
tmimaselect +='<input class="form-control input-sm eltmimalesson" required value="" name="ellak" placeholder="Ανοιχτή Τεχνολογία/Λογισμικό/Περιεχόμενο" type="text">';
tmimaselect +='<input class="form-control input-sm eltmimalessonurl" value="" name="ellakurl" placeholder="Πληκτρολογήστε το url της Ανοιχτής Τεχνολογίας/Λογισμικού/Περιεχομένου που χρησιμοποιείτε" type="text">';

tmimaselect +='<button class="del_field_button" type="button" style="color:blue">Διαγραφή μαθήματος</button>';
tmimaselect +='<button class="add_field_button_url pull-right" type="button" style="color:blue;">Προσθήκη τεχνολογίας</button>';
tmimaselect +='<div style="margin-top:5px"> &nbsp; </div>';
tmimaselect +='</div>';
tmimaselect +='</div>';
tmimaselect +='</div>';

tmimaselecturl ='<label class="eltmimalessonurl control-label required hidden-xs hidden-sm col-md-3" for="el-mathimatechnologia">Ανοιχτή Τεχνολογία </label>';
tmimaselecturl +='<div class="eltmimalessonurldiv eltmimalessonurl col-xs-12 col-sm-12 col-md-9">';
tmimaselecturl +='<input class="form-control input-sm eltmimalesson eltmimalessonurl" required value="" name="ellak" placeholder="Ανοιχτή Τεχνολογία/Λογισμικό/Περιεχόμενο" type="text">';
tmimaselecturl +='<input class="form-control input-sm eltmimalessonurl" value="" name="ellakurl" placeholder="Πληκτρολογήστε το url της Ανοιχτής Τεχνολογίας/Λογισμικού/Περιεχομένου που χρησιμοποιείτε" type="text">';
tmimaselecturl +='<button class="del_field_button_url pull-right eltmimalessonurl" type="button" style="color:blue;">Διαγραφή τεχνολογίας</button>';
tmimaselecturl +='<button class="add_field_button_url pull-right eltmimalessonurl" type="button" style="color:blue;">Προσθήκη τεχνολογίας</button>';
tmimaselecturl +='<div class="eltmimalessonurl" style="margin-top:5px"> &nbsp; </div>';
tmimaselecturl +='</div>';
tmimaselecturl +='</div>';
tmimaselecturl +='</div>';

tmimaselecturlmeta ='<div class="eltimagroupmeta">';
tmimaselecturlmeta +='<label class="eltmimalessonurl metalessonlabel control-label hidden-xs hidden-sm col-md-3 required" for="el-metatitlos">Τίτλος μεταπτυχιακού </label>';
tmimaselecturlmeta +='<div class="eltmimalessonurldiv eltmimalessonurl metalessoninput col-xs-12 col-sm-12 col-md-9">';
tmimaselecturlmeta +='<input class="form-control input-sm eltmimalesson eltmimalessonurl" value="" name="metatitlos" placeholder="Όνομα μεταπτυχιακού προγράματος" type="text" required>';
tmimaselecturlmeta +='</div>';
tmimaselecturlmeta +='<label class="eltmimalessonurl control-label hidden-xs hidden-sm col-md-3 required" for="el-metamathima">Μάθημα/Εργαστήριο</label>';
tmimaselecturlmeta +='<div class="eltmimalessonurldiv eltmimalessonurl col-xs-12 col-sm-12 col-md-9">';
tmimaselecturlmeta +='<input class="form-control input-sm eltmimalesson eltmimalessonurl" value="" name="metamathima" required placeholder="Μάθημα/Εργαστήριο" type="text">';
tmimaselecturlmeta +='</div>';

tmimaselecturlmeta +='<label class="eltmimalessonurl control-label required hidden-xs hidden-sm col-md-3" for="el-metatechnologia">Ανοιχτή Τεχνολογία</label>';
tmimaselecturlmeta +='<div class="eltmimalessonurldiv eltmimalessonurl col-xs-12 col-sm-12 col-md-9">';
tmimaselecturlmeta +='<input class="form-control input-sm eltmimalesson eltmimalessonurl" required  value="" name="ellak" placeholder="Ανοιχτή Τεχνολογία/Λογισμικό/Περιεχόμενο" type="text">';
tmimaselecturlmeta +='<input class="form-control input-sm eltmimalessonurl" value="" name="ellakurl" placeholder="Πληκτρολογήστε το url της Ανοιχτής Τεχνολογίας/Λογισμικού/Περιεχομένου που χρησιμοποιείτε" type="text">';
tmimaselecturlmeta +='<button class="del_field_button" type="button" style="color:blue">Διαγραφή μαθήματος</button>';
tmimaselecturlmeta +='<button class="add_field_button_url pull-right eltmimalessonurl" type="button" style="color:blue;">Προσθήκη τεχνολογίας</button>';
tmimaselecturlmeta +='<div class="eltmimalessonurl" style="margin-top:5px"> &nbsp; </div>';
tmimaselecturlmeta +='</div>';
tmimaselecturlmeta +='</div>';
tmimaselecturlmeta +='</div>';
tmimaselecturlmeta +='</div>';


tmimaselecturlmeta1 ='<div class="eltimagroupmeta1"><label class="eltmimalessonurl  control-label hidden-xs hidden-sm col-md-3 required" for="el-metamathima">Μάθημα/Εργαστήριο</label>';
tmimaselecturlmeta1 +='<div class="eltmimalessonurldiv eltmimalessonurl col-xs-12 col-sm-12 col-md-9">';
tmimaselecturlmeta1 +='<input class="form-control input-sm eltmimalesson eltmimalessonurl" value="" name="metamathima" placeholder="Μάθημα/Εργαστήριο" required type="text">';
tmimaselecturlmeta1 +='</div>';

tmimaselecturlmeta1 +='<label class="eltmimalessonurl control-label required hidden-xs hidden-sm col-md-3" for="el-metatechnologia">Ανοιχτή Τεχνολογία</label>';
tmimaselecturlmeta1 +='<div class="eltmimalessonurldiv eltmimalessonurl col-xs-12 col-sm-12 col-md-9">';
tmimaselecturlmeta1 +='<input class="form-control input-sm eltmimalesson eltmimalessonurl" required value="" name="ellak" placeholder="Ανοιχτή Τεχνολογία/Λογισμικό/Περιεχόμενο" type="text">';
tmimaselecturlmeta1 +='<input class="form-control input-sm eltmimalessonurl" value="" name="ellakurl" placeholder="Πληκτρολογήστε το url της Ανοιχτής Τεχνολογίας/Λογισμικού/Περιεχομένου που χρησιμοποιείτε" type="text">';
tmimaselecturlmeta1 +='<button class="del_field_button" type="button" style="color:blue">Διαγραφή μαθήματος</button>';
tmimaselecturlmeta1 +='<button class="add_field_button_url pull-right eltmimalessonurl" type="button" style="color:blue;">Προσθήκη τεχνολογίας</button>';
tmimaselecturlmeta1 +='<div class="eltmimalessonurl" style="margin-top:5px"> &nbsp; </div>';
tmimaselecturlmeta1 +='</div>';
tmimaselecturlmeta1 +='</div>';
tmimaselecturlmeta1 +='</div>';
tmimaselecturlmeta1 +='</div>';



tmimaerg =  '<p>Συμμετέχετε σε καποιο εργαστήριο/ερευνητική ομάδα στο ίδρυμα σας, που ασχολείται ή χρησιμοποιεί Ανοιχτές τεχνολογίες , Ανοιχτό λογισμικό ή περιεχόμενο?</p>';
tmimaerg +=  '	<div class="row">';
tmimaerg += '		<div class="col-sm-6">';
tmimaerg += '		    <div class="radio radio-inline">';
tmimaerg += '			<input class="radio1" name="ergastirio" id="radio1" value="OXI" checked="" type="radio">';
tmimaerg += '			<label for="radio1">';
tmimaerg += '			    Οχι';
tmimaerg += '			</label>';
tmimaerg += '		    </div>';
tmimaerg += '		    <div class="radio radio-inline">';
tmimaerg += '			<input class="radio1" name="ergastirio" id="radio2" value="NAI" type="radio">';
tmimaerg += '			<label for="radio2">';
tmimaerg += '			    Ναι';
tmimaerg += '			</label>';
tmimaerg += '		    </div>';
tmimaerg += '		</div>';
tmimaerg += '	</div>';
tmimaerg += '<div  style="margin-top:5px"> &nbsp; </div>';

tmimaerg1 ='<label class="control-label hidden-xs hidden-sm col-md-5" for="el-tmhmaerg">Όνομα εργαστηρίου/Ερευνητικής ομάδας</label>';
tmimaerg1 +='<div class="col-xs-12 col-sm-15 col-md-20">';
tmimaerg1 +='<input class="form-control input-sm eltmimalesson" value="" name="ergastirioonoma" placeholder="Όνομα εργαστηρίου/Ερευνητικής ομάδας" type="text">';
tmimaerg1 += '</div>';

tmimaerg1 +='<label class="control-label hidden-xs hidden-sm col-md-3" for="el-tmhmaergdrast">Δραστηριότητα</label>';
tmimaerg1 +='<div class="col-xs-12 col-sm-12 col-md-9">';
tmimaerg1 +='<input class="form-control input-sm eltmimalesson" value="" name="ergastiriodrastiriotita" placeholder="Δραστηριότητα" type="text">';
tmimaerg1 += '</div>';

tmimaerg1 +='<label class="control-label hidden-xs hidden-sm col-md-3" for="el-tmhmaergperigrafi">Περιγραφή</label>';
tmimaerg1 +='<div class="col-xs-12 col-sm-12 col-md-9">';
tmimaerg1 +='<input class="form-control input-sm eltmimalesson" value="" name="ergastirioperigrafi" placeholder="Περιγραφή δράσης" type="text">';
tmimaerg1 += '</div>';

tmimaerg1 +='<label class="control-label hidden-xs hidden-sm col-md-3" for="el-tmhmaergypefthinos">Υπεύθυνος</label>';
tmimaerg1 +='<div class="col-xs-12 col-sm-12 col-md-9">';
tmimaerg1 +='<input class="form-control input-sm eltmimalesson" value="" name="ergastirioypefthinos" placeholder="Υπεύθυνος Εργαστηρίου/Ομάδας" type="text">';
tmimaerg1 += '</div>';

tmimaerg1 +='<label class="control-label hidden-xs hidden-sm col-md-3" for="el-tmhmaergurl">Ιστοσελίδα</label>';
tmimaerg1 +='<div class="col-xs-12 col-sm-12 col-md-9">';
tmimaerg1 +='<input class="form-control input-sm eltmimalesson" value="" name="ergastiriourl" placeholder="Ιστοσελίδα Εργαστηρίου/Ομάδας" type="text">';
tmimaerg1 += '</div>';

tmimaselect1 ='<div class="col-xs-12 col-sm-12 col-md-9">';
tmimaselect1 +='<button id="add_field_button" class="btn btn-lg btn-primary" type="button" name="buttonerga">Προσθήκη Επιπλέον Μαθήματος</button>';
tmimaselect1 +='</div>';

var ok = '<h1> </h1>';
ok += ' <br> ';
ok += ' <br> ';
ok += '<p>';

ok += ' <br> ';
ok += ' <br> ';
ok += ' <br> ';
ok += '<h3>Σας ευχαριστούμε που συμπληρώσατε το ερωτηματολόγιο του Οργανισμού μας.</h3>'
ok += '<h3>Θα λάβετε ένα email με όλα τα στοιχεία που καταχωρίσατε.</h3>'
ok += '<h3>Η συμμετοχή σας είναι πολύτιμη.</h3>';
ok += ' <br> ';
ok += ' <br> ';
ok += '<h4> <a href="https://edu-quest.ellak.gr/view/">Αρχική σελίδα</a> </h4>';
ok += '</p>';

$('#el-sxolh').on('change', function () {
    var key = this.value;
    var unisxolh = $("#el-sxolh option").filter(":selected").text();
    var department = $("#el-idrima option").filter(":selected").text();
    var uni = $("#el-idrima option").filter(":selected").text();
    var unival = $("#el-idrima option").filter(":selected").val();
    var unitmp = unival.substring(0,1);
    if(NEWSELECT == 'dioikitiko'){
    }else{
	    $.ajax({
		url: API+'mathima',
		type: 'GET',
		data:{"institution":department,"unisxolh":unisxolh},
		dataType: 'json',
		success: function (data, statusText, resObject) {
			if(NEWSELECT == 'meta'){
				$('#eltmhmalession').empty();
				$('#eltmhmalession').append(tmimaselecturlmeta);
				$('#add_field_button').remove();
				$('#eltmhmalessionadd').prepend(tmimaselect1);
			}else if (unitmp == 'i'){
				$('#eltmhmalession').empty();
				$('#eltmhmalession').append(tmimaselecturlmeta1);
				$('#add_field_button').remove();
				$('#eltmhmalessionadd').prepend(tmimaselect1);
			}else{
				$('#eltmhmalession').empty();
				$('#eltmhmalession').append(tmimaselect);
				$('#add_field_button').remove();
				$('#eltmhmalessionadd').prepend(tmimaselect1);
				var selectlesson = $('#eltmhmalession').find("select:last");
				$.each(data.result.data, function(index, d){
					selectlesson.append($("<option></option>")
							    .attr("value", d.id)
							    .text(d.lesson));
				});
			}
		}
	    });
    }
});


function getlessons() {
    var key = this.value;
    var unisxolh = $("#el-sxolh option").filter(":selected").text();
    var department = $("#el-idrima option").filter(":selected").text();
    $.ajax({
        url: API+'mathima',
        type: 'GET',
        data:{"institution":department,"unisxolh":unisxolh},
        dataType: 'json',
    	success: function (data, statusText, resObject) {
		var selectlesson = $('#eltmhmalession').find("select:last");
                $.each(data.result.data, function(index, d){
                        selectlesson.append($("<option></option>")
                                            .attr("value", d.id)
                                            .text(d.lesson));
                });
        }
    });
};

$(document).on('click', '#add_field_button', function(){ 
    var max_fields = 10; //maximum input boxes allowed
    var add_button = $("#add_field_button"); //Add button ID
    var unival = $("#el-idrima option").filter(":selected").val();
    var unitmp = unival.substring(0,1);
    if(NEWSELECT == 'meta'){
    	$('#eltmhmalession').append(tmimaselecturlmeta);
	var items = $('#eltmhmalession').find('.eltimagroupmeta').length;
	if(items > 1){
		$('#eltmhmalession').find('.eltimagroupmeta').last().find('.metalessonlabel').remove();	
		$('#eltmhmalession').find('.eltimagroupmeta').last().find('.metalessoninput').remove();	
	}
    }else if(unitmp == 'i'){
    	$('#eltmhmalession').append(tmimaselecturlmeta1);
    }else{
    	$('#eltmhmalession').append(tmimaselect);
    	getlessons();
    }
});

$(document).on('change', '.radio1', function(){ 
	var radio = $('input[name=ergastirio]').filter(':checked').val();
	if(radio == "OXI"){
    		$('#tmimaerg1').empty();
	}
	if(radio == "NAI"){
    		$('#tmimaerg1').append(tmimaerg1);
	}


});

$(document).on('click', '.add_field_button_url', function(){ 
    	$(this).parent().parent().append(tmimaselecturl);
});

$(document).on('click', '.del_field_button_url', function(){ 
	$(this).parent().prev('label.eltmimalessonurl').remove();
	$(this).parent().remove();
});

$(document).on('click', '.del_field_button', function(){ 
    	var del = $(".del_field_button"); //Fields wrapper
	$(this).parent().parent().remove();
});


$(document).on('click', '#refresh', function(){ 
		change_captcha();
});
 
 function change_captcha()
 {
	document.getElementById('captcha').src=API+"/view/captcha/captcha.php?rnd=" + Math.random();
 }
$('form').submit(function(e){ e.preventDefault(); });
$(document).on('click', '#submit', function(e){ 
//e.preventDefault();
    var $myForm = $('#tableresponsive1');
    if(! $myForm[0].checkValidity()) {
    } else {
	var captcha = $('#code').val();
            $.ajax({
                url: API+'captcha',
                type: 'GET',
                data:{"code":captcha},
                dataType: 'json',
                success: function (data, statusText, resObject) {
var response = data['result'];
		
		if(response==1)
		{
			    $('#submit').prop('disabled', true);
			    var newselect = $("#newselect option").filter(":selected").text();
			    var onoma = $("#el-onoma").val();
			    var epitheto = $("#el-epitheto").val();
			    var email = $("#el-email").val();
			    var unisxolh = $("#el-sxolh option").filter(":selected").text();
			    var department = $("#el-idrima option").filter(":selected").text();
			    var etmimalession = {};
			    var c=0;
			    var cc=0;

			    var summary = {};
			    summary['ellak'] = [];
			    summary['ellakurl'] = {};
			    var ellak = {};
			    var MATHIMA;

			$('input, select, textarea').each( function(index){  
				var input = $(this);
				if(input.attr('name') == 'idrima'){
					var textidr = input.find('option:selected').text();
					var textname = input.attr('name');
					summary[textname] = textidr;
				}else if(input.attr('name') == 'sxolh'){
					var textidr = input.find('option:selected').text();
					var textname = input.attr('name');
					summary[textname] = textidr;
				}else if(input.attr('name') == 'mathima'){
					var textidr = input.find('option:selected').text();
					var textname = input.attr('name');
					summary[textname] = textidr;
					MATHIMA=textidr;
				}else if(input.attr('name') == 'metamathima'){
					var textidr = input.val();
					var textname = input.attr('name');
					summary[textname] = textidr;
					MATHIMA=textidr;
				}else if(input.attr('name') == 'ellak'){
					var textidr = input.val();
					var textname = input.attr('name');
					ellak =  {
						mathima:MATHIMA,
						tech: textidr,
						url: ''
					};
					summary['ellak'].push(ellak);
				}else if(input.attr('name') == 'ellakurl'){
					var textidr = input.val();
					var textname = input.attr('name');
					ellak =  {
						mathima:MATHIMA,
						tech: '',
						url: textidr
					};
					summary['ellak'].push(ellak);
				}else if(input.attr('name') == 'ergastirio'){
					var textidr = $('input[name=ergastirio]:checked').val();
					var textname = input.attr('name');
					summary[textname] = textidr;
				}else{
					var textidr = input.val();
					var textname = input.attr('name');
					summary[textname] = textidr;
				}
			    }
			    );
				var serializedArr = JSON.stringify( summary );
				var serializedArr1 = JSON.stringify( ellak );
				    $.ajax({
					url: API+'mathima',
					type: 'POST',
					data:{"data":serializedArr, "ellak":ellak},
					dataType: 'json',
					success: function (data, statusText, resObject) {
						$('#tableresponsive').empty();
						$('#tableresponsive1').empty();
						$('#footer').empty();
						$('#tableresponsive1').append(ok);
					}
				    });
			}
			else
			{
				$("#after_submit").empty();
				$("#after_submit").append('Error ! invalid captcha code.');
		        }//cap   
                }//success
            });//ajax
	} //else valid
    }); 

});

