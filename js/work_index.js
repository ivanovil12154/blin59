let win_MOOverduelist = document.querySelector("#win_MOOverduelist");
let grid_MOOverduelist = win_MOOverduelist.querySelector(".grid");
let win_file_save = document.querySelector("#win_file_save");
let win_file_list = document.querySelector("#win_file_list");
let grid_file_list = win_file_list.querySelector(".grid");

let Win_list=[win_MOOverduelist, win_file_save, win_file_list];

VisibleWin(Win_list, null);

/****************************************** */
/****************************************** */
/****************************************** */

function KeyGoUserList(){
	let params = {VGIDUser: GIDUser, 
		         VGUserFIO: GUserFIO, 
				 VGLogin: GUserLogin,
				 VGSession: GSession};
    postToSameTab("work_user_sp.php", params);
};
///////////////////////////////////////////////////////////////////
function KeyMOOverdue_Click(){
	let v = document.querySelector("#serch_fio");
	let v1 = v.value;
	let LFormDate = new FormData;
		LFormDate.append('VID', GIDUser);
		LFormDate.append('VLogin', GUserLogin);
		LFormDate.append('VSession', GSession);
		LFormDate.append('VFunction', "MOOverdueList"); 
		LFormDate.append('VMethod', "GET");
		LFormDate.append('VSerchFio', document.querySelector("#serch_fio").value);
		LFormDate.append('VSerchOffi', document.querySelector("#serch_offise").value);
		LFormDate.append('VSerchMOT', document.querySelector("#serch_mot").value);
		elem_remove_all(grid_MOOverdueList);
    	SendData('../fphp/phpsql.php', LFormDate, KeyMOOverdue_ClickOK, 'MOType', FERR_Error);
};	

function GeneratorRow(Row0, names){
	let classRow = "";
	let classTD = "";
	if (Row0 == true){
		classRow = "grid-tr-0";
		classTD = "grid-td_mo";
	} else {
		classRow = "grid-tr";
		classTD = "grid-td_mo";
	}

    let elemrow = document.createElement('div');
	elemrow.className = classRow;
	grid_MOOverduelist.append(elemrow);

	for (let c = 0; c < names.length; c++){
		elem0 = document.createElement('div');		  
		elem0.className = classTD;
		elemrow.append(elem0);

		elem1 = document.createElement('div');		  
		elem1.className = "item";
		elem1.innerHTML = names[c];
		elem0.append(elem1);
	}
}

function KeyMOOverdue_ClickOK(str, param){  
  	const arr = JSON.parse(str);
	for (let q = 0; q < arr.length; q++){
	    if ((arr[q][0][0] == "OK") && (arr[q][0][1] > 0)){
			if (q == 0){
				GeneratorRow(true, ["Персонал", "Место. раб", "MO", "Кол-во в жизни", "Кол-во сделано"]);
			} else if (q == 1){
				GeneratorRow(true, ["Персонал", "Место. раб", "MO", "Кол-во на работе", "Кол-во сделано"]);
			} else if (q == 2){
				GeneratorRow(true, ["Персонал", "Место. раб", "MO", "Дата окончания", "Кол-во месяц"]);
			}	

    		for (let r = 1; r < arr[q].length; r++) {
				if (q < 2){
					GeneratorRow(false, [arr[q][r].UserNameS, arr[q][r].OfName, arr[q][r].MOTName, arr[q][r].MOAV, arr[q][r].MODONE]);
				} else {
					if (arr[q][r].TTTT > 1000) {
						GeneratorRow(false, [arr[q][r].UserNameS, arr[q][r].OfName, arr[q][r].MOTName, "-", "-"]);
					} else {
						GeneratorRow(false, [arr[q][r].UserNameS, arr[q][r].OfName, arr[q][r].MOTName, arr[q][r].MODONE, arr[q][r].TTTT]);
					}	
				}
			}
		}
	};
	VisibleWin(Win_list, win_MOOverduelist);
};

/*********************************************** */
/*********************************************** */
function KeyFileList_Click(){
	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
	LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "FileList"); 
	LFormDate.append('VMethod', "GET");
    SendData('../fphp/phpsql.php', LFormDate, KeyFileList_response, '', FERR_Error);
};

function KeyFileList_response(str, param){
  	const arr = JSON.parse(str);
    if (arr[0][0][0] != "OK"){
		alert ("Ошибка");
	};

	for (let r = 1; r < arr[0].length; r++) {
		VarRow = GeneratorRowForGrid("grid-tr", "grid-td", "item",  
			 [arr[0][r].FileDateCreate, 
               arr[0][r].UserNameS, 
			   arr[0][r].FileName, 
			   arr[0][r].FileDesc]);
		CellButton = document.createElement('div');	   
		CellButton.className = "grid-td";
		VarRow.append(CellButton);

		CellBuItems = document.createElement('input');		  
		CellBuItems.type = "button"
//		CellBuItems.innerHTML = "Загрузить";
		CellBuItems.onclick = KeyLoadFileOnly_click;
		CellBuItems.setAttribute("IDFile", arr[0][r].IDFile);
		CellButton.append(CellBuItems);
 		grid_file_list.append(VarRow);
	}
	VisibleWin(Win_list, win_file_list);

};	
/////////////////////////////////////////////////
/////////////////////////////////////////////////
function KeyFileSaveForm_Click(){
	VisibleWin(Win_list, win_file_save);
};

/*********************************************** */
/*********************************************** */

function KeyLoadFileOnly_click(){
	let IDF = this.getAttribute("IDFIle");
	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
	LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "LoadFileOnly"); 
	LFormDate.append('VMethod', "GET");
	LFormDate.append('VIDFile', IDF);
    SendData('../fphp/phpsql.php', LFormDate, KeyLoadFileOnly_response, '', FERR_Error);
};

function KeyLoadFileOnly_response(str, para){
  	const arr = JSON.parse(str);
    if (arr[0][0][0] != "OK"){
		return;
	};
    if (arr[0][0][1] < 1){
		alert ("Файл не наден");
		return;
	};

	let res = "";
	for (let ind = 1; ind < arr[0].length; ind++){
		res = res + arr[0][ind].FDData;
	}

	let ind = res.indexOf(";base64,")
	let TD = res.slice(5, ind);
	let res1 = res.slice(ind+8);

	blob = Base64ToBlob(res1, TD);
	saveFile(blob, arr[0][1].FileName);
}

/******************************************* */
function KeyFileSave_click(){
   	let IDSaveFile = document.querySelector("#IDSaveFile");
	let IDFSDesc = win_file_save.querySelector("#IDFSDesc");
	let IDSelectPrivilege = win_file_save.querySelector("#IDSelectPrivilege");

    const file = IDSaveFile.files[0]; // Получаем выбранный файл
	if (!file) {
		alert("Не выбра файл");
	};
	if (file.size == 0) {
		alert("Файл пустой");
	};
/**************** Версия2 для  */
	const reader = new FileReader();
  	reader.onload = (e) => {
    	const content = e.target.result; // Содержимое файла
		KeyFileSave_base64(content, file, IDSelectPrivilege.value, IDFSDesc.value);
    };
	//reader.readAsText(file); // Читаем как текст
	//reader.readAsText(file); // Читает файл как текстовую строку.
	reader.readAsDataURL(file);// Читает файл в виде base64 строки (для картинок).
	//reader.readAsArrayBuffer(file);// Читает в бинарном формате.
};

function KeyFileSave_base64(content, file, VPrivilege, VDesc){
	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
	LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "SaveFileMain"); 
	LFormDate.append('VMethod', "INSERT");
//	LFormDate.append('VFileData', content);	
	LFormDate.append('VFileSize', file.size);	
	LFormDate.append('VFileName', file.name);	
	LFormDate.append('VDesc', VDesc);	
	LFormDate.append('VPrivilege', VPrivilege);	

    let mas = splitString(content, 1024*500);	
	let para = [];
	para["mas"] = mas;
	para["ID"] = 0;
    SendData('../fphp/phpsql.php', LFormDate, KeyFileSave_Main, para, FERR_Error);
}
function KeyFileSave_Main(str, para){
	const arr = JSON.parse(str);
    if (arr[0][0][0] != "OK"){
		alert('Ошибка при записи');
        return;
    };
	if (para["mas"].length <1 ){
		alert('Файл успешно сохранен в базе данных');
		VisibleWin(Win_list, null);
		return;
	};
	if (para["ID"] < 1) {
		para["ID"] = arr[0][0][2];
	}

	let LFormDate = new FormData;
	LFormDate.append('VFunction', "SaveFileData"); 
	LFormDate.append('VMethod', "INSERT");
//	LFormDate.append('VFileData', content);	
	LFormDate.append('VFileData', para["mas"][0]);	
	LFormDate.append('VFileID', para["ID"]);	
	para["mas"].splice(0, 1);
    SendData('../fphp/phpsql.php', LFormDate, KeyFileSave_Main, para, FERR_Error);
}

function KeyFileSave_Requst(str, para){
	const arr = JSON.parse(str);
    if (arr[0][0] != "OK"){
		alert('Файл успешно сохранен в базе данных');
        return;
    };
};

function FERR_Error(str, param){
	alert ('Ошибка')
	return;
};



function KeyCansel_click(){

};

function work_getuserlist1(){
	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
    SendData('../fphp/work/GetUserList.php', LFormDate, FunGUOK, '', FunGUError);
};	

function FunGUOK1(str, param){
    alert ('Удача - ' + str); 
}

function FunGUError1(str, param){
	alert ('Ошибка')
	return;
};

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
 
function FunNLError1(str, param){
	alert ('Ошибка')
	return;
};
