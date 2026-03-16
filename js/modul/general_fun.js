function elem_remove_all(gelem){
    elems = gelem.querySelectorAll("*");
    if (elems != null){
        for (let element of elems) {
            element.remove();
        };
    };    
};

function GeneratorRowForGrid(ClassRow, ClassCell, ClassItem, names){
    let elemrow = document.createElement('div');
	elemrow.className = ClassRow;
	grid_MOOverduelist.append(elemrow);

	for (let c = 0; c < names.length; c++){
		elem0 = document.createElement('div');		  
		elem0.className = ClassCell;
		elemrow.append(elem0);

		elem1 = document.createElement('div');		  
		elem1.className = ClassItem;
		elem1.innerHTML = names[c];
		elem0.append(elem1);
	}
    return elemrow; 
};

// разбить строку на массив с определенным кол символов
function splitString(str, length) {
  const result = [];
  for (let i = 0; i < str.length; i += length) {
    result.push(str.slice(i, i + length));
  }
  return result;
}

function VisibleWin(SpisWin, VisWin){
    for (let ind = 0; ind < SpisWin.length; ind++){
        if (SpisWin[ind] == VisWin) {
            SpisWin[ind].classList.remove('elem_hide');
        } else {
            SpisWin[ind].classList.add('elem_hide');
        }
  
    }
}
