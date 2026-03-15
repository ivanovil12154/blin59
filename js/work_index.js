let win_MOOverduelist = document.querySelector("#win_MOOverduelist");
let grid_MOOverduelist = win_MOOverduelist.querySelector(".grid");

let win_file_save = document.querySelector("#win_file_save");


win_MOOverduelist.classList.add("elem_hide");



function KeyGoUserList(){
	let params = {VGIDUser: GIDUser, 
		         VGUserFIO: GUserFIO, 
				 VGLogin: GUserLogin,
				 VGSession: GSession};
    postToSameTab("work_user_sp.php", params);
};

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
	win_MOOverduelist.classList.remove("elem_hide");
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
	}
};
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

function KeyFileList_response(){
  	const arr = JSON.parse(str);
    if ((arr[0][0][0] == "OK") && (arr[0][0][1] > 0)){
	};
};	
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
	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
	LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "SaveFile"); 
	LFormDate.append('VMethod', "SET");
	LFormDate.append('VFileData', file);	
	LFormDate.append('VFileSize', file.size);	
	LFormDate.append('VDesc', IDFSDesc.value);	
	LFormDate.append('VPrivilege', IDSelectPrivilege.value);	
    SendData('../fphp/phpsql.php', LFormDate, KeyFileSave_Requst, '', FERR_Error);
};

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
/*

	const arr = JSON.parse(str);
	if (arr.res == "OK") {
      alert ('Удача - ' + arr.name); 
	  document.location.href = '../workfol/workindex.php';

	} else if (arr.res == "ErrorLogin") {
		alert ("Ошибка, логин или пароль не найдены");
	}
*/

/*
	if (str == 'LClose'){
		alert ('Логин занят')
		return;
	};

	if (str != 'OK'){
		alert ('Ошибка')
		return;
	};
    alert ('Удача')
	return;

	OnClickCloseWinPred();
	Llogin = param;
    */
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
