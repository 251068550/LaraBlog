var TableDatatablesAjax = function() {
  var datatableAjax = function(){
    dt = $('.dataTablesAjax');
		ajax_datatable = dt.DataTable({
			"processing": true,
      "serverSide": true,
      "searching" : true,
      "searchDelay": 800,
      "search": {
        "regex": true
      },
      "ajax": {
        'url' : 'role/ajaxIndex',
      },
      "pagingType": "full_numbers",
      "orderCellsTop": true,
      "dom" : '<"html5buttons"B>lTfgitp',
      "buttons": [
        {extend: 'copy',title: 'role'},
        {extend: 'csv',title: 'role'},
        {extend: 'excel', title: 'role'},
        {extend: 'pdf', title: 'role'},
        {extend: 'print',
         customize: function (win){
            $(win.document.body).addClass('white-bg');
            $(win.document.body).css('font-size', '10px');
            $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
          }
        }
      ],
      "columns": [
        {
        	"data": "id",
        	"name" : "id",
      	},
        {
        	"data": "name",
        	"name" : "name",
        	"orderable" : false,
        },
        {
        	"data": "slug",
        	"name": "slug",
        	"orderable" : false,
        },
        { 
          "data": "description",
          "name": "description",
          "orderable" : false,
        },
        { 
        	"data": "created_at",
        	"name": "created_at",
        	"orderable" : true,
        },
        { 
        	"data": "updated_at",
        	"name": "updated_at",
        	"orderable" : true,
        },
        { 
          "data": "actionButton",
          "name": "actionButton",
          "type": "html",
          "orderable" : false,
        },
    	],
      "drawCallback": function( settings ) {
        ajax_datatable.$('.tooltips').tooltip( {
          placement : 'top',
          html : true
        });  
      },
      "language": {
        url: 'i18n'
      }
    });
    // 关闭modal清空内容
    $(".modal").on("hidden.bs.modal",function(e){
       $(this).removeData("bs.modal");
    });
  };
	return {
		init : datatableAjax
	}
}();
$(function () {
  TableDatatablesAjax.init();
});