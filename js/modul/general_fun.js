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


///////////////////////////////////////////
function Base64ToBlob(data, TD){
	const base64Data = data;
//	const contentType = 'image/png'; // Укажите правильный MIME-тип
	let contentType = ''; 

    if (TD != null && TD.length > 0) {
        contentType = TD; 
    } else {
        contentType = 'application/octet-stream'; 
    };
	

	// 1. Декодируем base64
	const sliceSize = 512;
	const byteCharacters = atob(base64Data);
	const byteArrays = [];

	// 2. Преобразуем в бинарный формат
	for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
  		const slice = byteCharacters.slice(offset, offset + sliceSize);
  		const byteNumbers = new Array(slice.length);
  		for (let i = 0; i < slice.length; i++) {
    		byteNumbers[i] = slice.charCodeAt(i);
  		}
  		const byteArray = new Uint8Array(byteNumbers);
  		byteArrays.push(byteArray);
	}

	// 3. Создаем Blob
	const blob = new Blob(byteArrays, {type: contentType});
	return blob;
};	

function saveFile(blob, filename) {
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  
  a.style.display = 'none';
  a.href = url;
  a.download = filename;
  document.body.appendChild(a);
  a.click();
  
  window.URL.revokeObjectURL(url);
  document.body.removeChild(a);
}

