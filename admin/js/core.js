/**
 * 
 */
function jSelectArticle_jform_request_id(id, title, catid, object) {
		document.id("jform_request_id_id").value = id;
		document.id("jform_request_id_name").value = title;
		SqueezeBox.close();
	}
function jInsertFieldValue(value, id) {
		var old_id = document.id(id).value;
		if (old_id != id) {
			var elem = document.id(id)
			elem.value = value;
			elem.fireEvent("change");
		}
}

var CoreJs = {
		checkAll: function(id){
			if(jQuery("#"+id+" input").attr("checked")){
				$("input[name='rad_ID[]']").each(function(){
					this.checked = true;
				})
			}
			else
			{
				$("input[name='rad_ID[]']").each(function(){
					this.checked = false;
				})
			}
		},
		
		deleteAll: function(url){
			var data = new Array()
			i=0
			$("input[name='rad_ID[]']").each(function(){
					if(this.checked==true && this.value!='')
							data[i] = this.value;
					i++;
				
			})
			if(data.join(':')!=''){
				if(confirm('Are you sure you want to delete this item?')){
					jQuery.ajax({
						url: url,
						data: {data:data.join(':')},
						dataType:'html',
						type: 'post',
						success: function(msg){
							window.location.reload();
						  }
					})
				}
			}else{
				alert("You must choice a record to remove.")
			}
			return false;
		},
}
var createnicename = function(el){
    //str= $(this).val().trim();
    str= el.value;
    str= str.toLowerCase();
    str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
    str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
    str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
    str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
    str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
    str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
    str= str.replace(/đ/g,"d");
    //        str= str.replace(/ |#|&|\(|\)|\?|{|}|\[|]|!|@|%|\$|\^|\*|\+/g,"-");
    str= str.replace(/\W/g,"-");
    $('.txtrcv').val(str);
}
$(document).ready(function() {
	$('.txtchange').keypress(function(){
	    var _self = this;
	    setTimeout(function(){
	        createnicename(_self);
	    },100);
	});
})
