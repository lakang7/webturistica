// JavaScript Document
window.addEvent('domready',function(){

	var table = document.id('highlight-table');
	var rows = table.getElements('tr');

	//for every row...
	rows.each(function(tr,trCount){
        //we don't want the header
        if(tr.getParent().get('tag') == 'thead') { return false; }
        //add the row class to the row
        tr.addClass('row-' + trCount);
        //add the row listener
        tr.addEvents({
                'mouseenter': function(){
                        tr.addClass('row-hover');
                },
                'mouseleave': function(){
                        tr.removeClass('row-hover');
                }
        });
        //for every cell...
		/*
				//-----------------DESCOMENTAR ESTE EVENTO SI SE QUIERE SOMBREAR LA COLUMNA Y CELDA SELECCIONADA
        tr.getElements('td').each(function(td,tdCount) {
                //remember column and column items
                var column = 'col-' + tdCount;
                var friends = 'td.' + column;
                //add td's column class
                td.addClass(column);
                //add the cell and column event listeners
				td.addEvents({
                        'mouseenter': function(){								
                                $$(friends).erase(td).addClass('column-hover');
								td.addClass('cell-hover');
                        },
                        'mouseleave': function() {
								$$(friends).erase(td).removeClass('column-hover');
								td.removeClass('cell-hover');
                        }
                });
        });*/
	}); //end for every row     
});