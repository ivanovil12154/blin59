/*********************  Declare ************************* */
let win_user_list = document.querySelector("#user_list");
let win_user_edit = document.querySelector("#win_user_edit");
let win_user_edit_MOO = document.querySelector("#win_user_edit_MOO");
let win_user_MOADD = document.querySelector("#win_user_MOADD");
let win_showmo_list = document.querySelector("#win_showmo_list");
let win_user_moaddlistperi = document.querySelector("#win_user_moaddlistperi"); 
     
let win_list = [win_user_list, 
	            win_user_edit, 
				win_user_edit_MOO,
				win_user_MOADD, 
				win_showmo_list, 
				win_user_moaddlistperi];
VisibleWin(win_list, win_user_list)

let win_user_list_grid = document.querySelector("#user_list_gird");
let win_user_edit_prof = document.querySelector("#UserEditProf");
let win_user_edit_offi = document.querySelector("#UserEditOffi");

let Elem_List_MOType = document.querySelector("#ListMOType");
let elem_grid_list_showmo = document.querySelector("#grid_list_showmo");




let Elem_KUR = null;
let Edit_Reg = "ADD";
let Edit_ID = 0;
let Edit_FIO = '';



work_get_proffesion_list(work_get_office_list);  

//work_get_office_list();  
//work_get_userlist();

/*********************  Function Get ************************* */
function work_get_proffesion_list(){
	let LFormDate = new FormData;
    LFormDate.append('VNameSpis', 'ProfList');
    SendData('../fphp/work/GetList.php', LFormDate, FOK_GetProfOffiList, 'prof', FERR_GetUserList);
};

function work_get_office_list(){
	let LFormDate = new FormData;
    LFormDate.append('VNameSpis', 'OffiLis');
    SendData('../fphp/work/GetList.php',  LFormDate, FOK_GetProfOffiList, 'offi', FERR_GetUserList);
};

function GetMOTypeList(){
	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
	LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "GetMOTypeList"); 
	LFormDate.append('VMethod', "GET");
    SendData('../fphp/phpsql.php', LFormDate, FOK_GetProfOffiList, 'MOType', FERR_GetUserList);
};

function FOK_GetProfOffiList(str, param){
	const arr = JSON.parse(str);
    if (arr[0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };
 //   alert ('Удача, кол-во записей - ' + arr[0][1]);     

    elemselect = null;
	if (param == 'prof'){
		elemselect = win_user_edit_prof;
	}else if (param == 'offi'){
		elemselect = win_user_edit_offi;
	}else if (param == 'MOType'){
        elemselect = Elem_List_MOType;		
	};

	if (elemselect != null) {
	    let cr = arr.length;
   		if (cr > 1){
      		for (let r = 1; r < arr.length; r++) {
				let elemopt = document.createElement('option');
				if (param == 'MOType'){
					elemopt.value = arr[r].f_id;
					elemopt.text = arr[r].f_name;
					elemopt.setAttribute("MOTPeriodMon", arr[r].MOTPeriodMon);
					elemopt.setAttribute("MOTOnlyLife", arr[r].MOTOnlyLife);
					elemopt.setAttribute("MOTOnlyBegin", arr[r].MOTOnlyBegin);
				} else {
					elemopt.value = arr[r][0];
					elemopt.text = arr[r][1];
				}
				//elemopt.selected = true; // Делает этот пункт активным
				elemselect.append(elemopt);
      		};
    	};
	};
  	
	if (param == 'prof'){
  		work_get_office_list();
	}else if (param == 'offi'){
		GetMOTypeList();
	}else if (param == 'MOType'){
		work_get_userlist();
	};
};


//////////////////////////////////////////////////////////////////////////
function work_get_userlist(){
//    alert ('запуск - '); 
	VisibleWin(win_list, win_user_list)   

   	user_list_del();

	let serch_fio = document.querySelector("#serch_fio");
	let serch_offi = document.querySelector("#serch_offi");
	let serch_prof = document.querySelector("#serch_prof");

	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
	LFormDate.append('VFunction', "GetSpisUserShot");
	LFormDate.append('VMethod', "GET");
	LFormDate.append('VSearchFIO', serch_fio.value);
	LFormDate.append('VSearchOffi', serch_offi.value);
	LFormDate.append('VSearchProf', serch_prof.value);
	
	LFormDate.append('VSelID', "");	
     
    SendData('../fphp/phpsql.php', LFormDate, FOK_GetUserList, '', FERR_GetUserList);
};	

//////////////////////////////////////////////////////////////////////////
function KeyEditUser_click(){
    IDUser = null;
	if (Elem_KUR != null){
		IDUser = Elem_KUR.getAttribute("IDUser");
	};

    if (IDUser < 1) {
  		alert("Персонал не определен")
		return;
	};

	VisibleWin(win_list,win_user_edit);   

	element = win_user_edit.querySelector(".wmain_zag");
	if (element != null){
		element.innerHTML = "Изменить данные персонала"
	}

	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
    LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "GetUserFull");
	LFormDate.append('VMethod', "GET");
	LFormDate.append('VSearchFIO', "");
	LFormDate.append('VSelID', IDUser);	
	Edit_ID = IDUser;
     
    SendData('../fphp/phpsql.php', LFormDate, FOK_GetUserFull, '', FERR_GetUserList);
};
/************************************************ */
function FOK_GetUserFull(str, param){
  	const arr = JSON.parse(str);
    if (arr[0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };
//    alert ('Удача, кол-во записей - ' + arr[0][1]);     
	let fio = win_user_edit.querySelector('[name="fio"]');	
	let prof = win_user_edit.querySelector('[name="prof"]');	
	let offi = win_user_edit.querySelector('[name="offi"]');		
	let login = win_user_edit.querySelector('[name="login"]');		
	let password = win_user_edit.querySelector('[name="password"]');		
	let status = win_user_edit.querySelector('[name="status"]');		
	let date_birth = win_user_edit.querySelector('[name="date_birth"]');		
	let date_begin = win_user_edit.querySelector('[name="date_begin"]');		

	fio.value = arr[1].UserNameS;
	prof.value = arr[1].UserProfID; 
	offi.value = arr[1].UserOfficeID;
	login.value = arr[1].UserLogin;
	password.value = "****"
	status.value = arr[1].UserStatus;
	date_birth.value = arr[1].UserDateBirth;
	date_begin.value = arr[1].UserDateBegin;

	element = win_user_edit.querySelector(".wmain_zag");
	if (element != null){
		element.innerHTML = "Изменить данные персонала - " + arr[1].UserNameS
	};
	Edit_Reg = "EDIT";
};	

function KeyEditMOO_click(){
    IDUser = null;
	if (Elem_KUR != null){
		IDUser = Elem_KUR.getAttribute("IDUser");
	};

    if (IDUser < 1) {
  		alert("Персонал не определен")
		return;
	};

	VisibleWin(win_list,win_user_edit_MOO);

	element = win_user_edit_MOO.querySelector(".wmain_zag");
	if (element != null){
		element.innerHTML = "Изменить данные персонала"
	};

	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
    LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "GetUserMOO");
	LFormDate.append('VMethod', "GET");
	LFormDate.append('VSearchFIO', "");
	LFormDate.append('VSelID', IDUser);	
	Edit_ID = IDUser;
     
    SendData('../fphp/phpsql.php', LFormDate, FOK_GetUserMOO, '', FERR_GetUserList);
};

function FOK_GetUserMOO(str, param){
  	const arr = JSON.parse(str);
    if (arr[0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };
//    alert ('Удача, кол-во записей - ' + arr[0][1]);     
	element = win_user_edit_MOO.querySelector(".wmain_zag");
	if (element != null){
		element.innerHTML = "Настройка обяз. мо для " + arr[1].UserNameS;
	};



    let mainelem = win_user_edit_MOO.querySelector(".form_edit_MO");

    let elements =  mainelem.querySelectorAll("*");
	for (let element of elements) {
      element.remove();
    };

    let cr = arr.length;
    if (cr > 1){
      for (let r = 1; r < arr.length; r++) {
        let elemrow1 = document.createElement('div');
        elemrow1.className = "form_edit_c0";
		elemrow1.innerHTML = arr[r].MOTName
		mainelem.append(elemrow1);

		let elemrow2 = document.createElement('div');

		mainelem.append(elemrow2);

		let eleminput = document.createElement('input');
		eleminput.type = "checkbox";
		eleminput.setAttribute("IDTypeMO", arr[r].IDMOType);
		if (arr[r].Obligatory > 0) {
          eleminput.checked = true;
		} else {
          eleminput.checked = false;
		}
		elemrow2.append(eleminput);
      };
    };
};

function KeyEditMOOSave_click(){
	const ObligMain = [];
	let mainelem = win_user_edit_MOO.querySelector(".form_edit_MO");
	let elements = mainelem.querySelectorAll("input");

	let id_mo = null;
	let oblic = null;
	for (let i = 0; i < elements.length; i++){
		id_mo = elements[i].getAttribute("IDTypeMO");
		if (elements[i].checked){
			oblic = 1;
		} else {
			oblic = 0;
		};
		const arr = [id_mo, oblic, Edit_ID];
		ObligMain.push(arr); 
	}
	const resultdata = JSON.stringify(ObligMain);

	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
    LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "UdMOO");
	LFormDate.append('VMethod', "SET");
	LFormDate.append('VData', resultdata);
	LFormDate.append('VIDUser', Edit_ID);
    SendData('../fphp/phpsql.php', LFormDate, FOK_UdMOO, '', FERR_AddUser);
};
function FOK_UdMOO(str, param){
	const arr = JSON.parse(str);
    if (arr[0][0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };
	work_get_userlist();
}

/******************************************************** */
/******************************************************** */
/******************************************************** */
/******************************************************** */

function KeyADDMO_click(){
	if ((Edit_FIO == '') || (Edit_ID == '')) {
		alert("Не выбран персонал");
		return;
	};

	VisibleWin(win_list,win_user_MOADD);


	let Zag = win_user_MOADD.querySelector(".wmain_zag");
	Zag.innerHTML = 'Добавить мед.осмотр для ' + Edit_FIO;

	let date_from = win_user_MOADD.querySelector('[name="date_from"]');		
//	let date_Еo = win_user_MOADD.querySelector('[name="date_to"]');		

    const d = new Date();
    const dateStr =  d.getFullYear() + '-' + 
	                (`0${d.getMonth() + 1}`).slice(-2) + '-' + 
	       			(`0${d.getDate()}`).slice(-2);
//	date_from.value = dateStr;
};



function ListMO_change(){
	let elemdesc = win_user_MOADD.querySelector("#MO_desc");
	let date_from = win_user_MOADD.querySelector('[name="date_from"]');		
	let date_to = win_user_MOADD.querySelector('[name="date_to"]');		
    const selectedIndex = Elem_List_MOType.selectedIndex;
    const MOTPeriodMon = Elem_List_MOType.options[selectedIndex].getAttribute("MOTPeriodMon");
    const MOTOnlyLife = Elem_List_MOType.options[selectedIndex].getAttribute("MOTOnlyLife");
    const MOTOnlyBegin = Elem_List_MOType.options[selectedIndex].getAttribute("MOTOnlyBegin");
	if (MOTPeriodMon > 0) {
		elemdesc.innerHTML = "Периодич. - " + MOTPeriodMon + "мес."

    	let dateStr = date_from.value;
		if (dateStr != ""){
	    	let parts = dateStr.split("-");
     
			let MontF = Number(parts[1]) - 1 + Number(MOTPeriodMon);	 
	 		let Year = Math.trunc(MontF / 12);
	 		let Mont = 0;
	 		if (Year > 0) {
	   			Mont = MontF - (Year * 12);
	 		}
	 		Year = Year + Number(parts[0]);
     		const s =  Year+ '-' + 
	                (`0${Mont + 1}`).slice(-2) + '-' + 
	       			(`0${parts[2]}`).slice(-2);
	 
			date_to.value = s;
		};	
	} else if (MOTOnlyLife > 0) {
		elemdesc.innerHTML = MOTOnlyLife + " -  в жизни";

	} else if (MOTOnlyBegin > 0) {
		elemdesc.innerHTML = MOTOnlyBegin + " -  при поступ.";
	} else {
		elemdesc.innerHTML = "";
	};  
};


function KeyADDMOSave_click(){
	let date_from = win_user_MOADD.querySelector('[name="date_from"]').value;		
	let date_to = win_user_MOADD.querySelector('[name="date_to"]').value;		
	let DopInf = win_user_MOADD.querySelector('[name="DopInf"]').value;		
	let MOType = Elem_List_MOType.value;
	let LFormDate = new FormData;
	if (date_to == ""){
		alert("Необходимо указать дату до")
		return;
	};
	if (date_from == ""){
		alert("Необходимо указать дату c")
		return;
	};
	if (MOType < 1) {
		alert("Необходимо указать Мед.Осомотр")
		return;
	}

	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
    LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "ADDMO");
	LFormDate.append('VMethod', "SET");
	LFormDate.append('VSelID', Edit_ID);
	LFormDate.append('VMOType', MOType);
	LFormDate.append('VDateFrom', date_from);
	LFormDate.append('VDateTo', date_to);
	LFormDate.append('VDopInf', DopInf);
  	SendData('../fphp/phpsql.php', LFormDate, FOK_KeyADDMOSave_click, '', FERR_AddUser);
};

function FOK_KeyADDMOSave_click(str, param){
	const arr = JSON.parse(str);
    if (arr[0][0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      return;
    };
	work_get_userlist();
};

/************************************* */
/************************************* */
/************************************* */
function KeyADDMOListPeri_click(){
	if (Edit_ID < 1){
		alert("Не указан персонал");
		return;
	};
	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
    LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "ADDMOListPeri_get");
	LFormDate.append('VMethod', "GET");
	LFormDate.append('VSelID', Edit_ID);
  	SendData('../fphp/phpsql.php', LFormDate, KeyADDMOListPeri_response, '', FERR_AddUser);

	VisibleWin(win_list,win_user_moaddlistperi);
};
function KeyADDMOListPeri_response(str, param){
	const arr = JSON.parse(str);
    if (arr[0][0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      return;
    };
	VisibleWin(win_list,win_user_moaddlistperi);	
	win_user_moaddlistperi.style.width = "683px";
	let form_grid = win_user_moaddlistperi.querySelector(".grid");  
	let elems = form_grid.querySelectorAll(".grid-tr");
	for (let elem of elems){
		elem.remove();
	}
	for (let row = 1; row < arr[0].length; row++ ){
		elemrow = document.createElement("div");
		elemrow.className = "grid-tr";
		elemrow.setAttribute("IDMOType", arr[0][row].IDMOType);
		elemrow.setAttribute("MOTPeriodMon", arr[0][row].MOTPeriodMon);
		form_grid.append(elemrow);
		
		elem1 = document.createElement("div");
		elem1.className = "grid-td";
		elem1.innerHTML = arr[0][row].MOTName;
		elemrow.append(elem1);

		elem1 = document.createElement("div");
		elem1.className = "grid-td";
		elem1.innerHTML = DateDBStrToDateUsStr(arr[0][row].DATETO);
		elemrow.append(elem1);

		elem1 = document.createElement("div");
		elem1.className = "grid-td";
		elem2 = document.createElement("input");
		elem2.type = "checkbox";
		elem2.onchange = chb_mo_enbaled;
		elem1.append(elem2);
		elemrow.append(elem1);

		elem1 = document.createElement("div");
		elem1.className = "grid-td";
		elem2 = document.createElement("input");
		elem2.type = "date";
		elem2.setAttribute("ElemName", "DateFrom");
		elem2.disabled = true;
		elem2.onchange = DateOnChange;
		
		elem1.append(elem2);
		elemrow.append(elem1);

		elem1 = document.createElement("div");
		elem1.className = "grid-td";
		elem2 = document.createElement("input");
		elem2.type = "date";
		elem2.setAttribute("ElemName", "DateTo");
		elem2.disabled = true;
		elem1.append(elem2);
		elemrow.append(elem1);
	}
};

function chb_mo_enbaled(){
	//let row = this.parentElement;
	let row = this.closest(".grid-tr");
	let DateFrom = row.querySelector('input[ElemName="DateFrom"]');
	let DateTo = row.querySelector('input[ElemName="DateTo"]');
	DateFrom.disabled = !this.checked;
	DateTo.disabled = !this.checked;
}

function DateOnChange(){
	let row = this.closest(".grid-tr");
	if (row != null){
		let Peri = row.getAttribute("MOTPeriodMon");
		let DateFrom = row.querySelector('input[ElemName="DateFrom"]');
		let DateTo = row.querySelector('input[ElemName="DateTo"]');

		let s = DateAddMont(DateFrom, Peri);
		if (s != ""){
			DateTo.value = s;
		}
	};
};

function KeyADDMOListPeriSave_onclick(){
	let form_grid = win_user_moaddlistperi.querySelector(".grid");  
	let Rows = form_grid.querySelectorAll(".grid-tr");
	let RowMain = [];

	for (let i=0; i < Rows.length; i++){
		let row = Rows[i];
		let DateFrom = row.querySelector('input[ElemName="DateFrom"]');
		let DateTo = row.querySelector('input[ElemName="DateTo"]');
        let IDMOType  = row.getAttribute("IDMOType");
		let Check = row.querySelector('input[type="checkbox"]');
		if (Check.checked){

			if (DateFrom.value == "") {
				Alert ("Не указана дата МО");
				return;
			}
			if (DateTo.value == "") {
				Alert ("Не указана дата до");
				return;
			}
			const RowOnly = [IDMOType, DateFrom.value, DateTo.value];
			RowMain.push(RowOnly);
		};	
	};
	const ResultData = JSON.stringify(RowMain);
	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
    LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "ADDMOListPeri_set");
	LFormDate.append('VMethod', "SET");
	LFormDate.append('VData', ResultData);
	LFormDate.append('VIDUser', Edit_ID);
    SendData('../fphp/phpsql.php', LFormDate, KeyADDMOListPeriSave_response, '', FERR_AddUser);
}

function KeyADDMOListPeriSave_response(str, para){
  	const arr = JSON.parse(str);
    if (arr[0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };
};
/************************************* */
/************************************* */
/************************************* */
/************************************* */
function KeyADDUser_click(){
	element = win_user_edit.querySelector(".wmain_zag");
	if (element != null){
		element.innerHTML = "Добавить персонал"
	}

	VisibleWin(win_list,win_user_edit);

	Edit_Reg = "ADD";


};

function  KeyDelUser_click(){
	VisibleWin(win_list,null);
};


///////////////////////////////////////////////////////////////
function user_list_del(){
    let elements =  win_user_list_grid.querySelectorAll(".grid-tr");
	for (let element of elements) {
    element.remove();
    };
}
///////////////////////////////////////////////////////////////
function grid_del_row(RowElem){
    let elements =  RowElem.querySelectorAll(".grid-tr");
	for (let element of elements) {
    element.remove();
    };
}

/////////////////////////////////////////////////
function FOK_GetUserList(str, param){
  	const arr = JSON.parse(str);
    if (arr[0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };
//    alert ('Удача, кол-во записей - ' + arr[0][1]);     

	let elem = null;
    let cr = arr.length;
    if (cr > 1){
      for (let r = 1; r < arr.length; r++) {
        let elemrow = document.createElement('div');
        elemrow.className = "grid-tr";
		elemrow.setAttribute("IDUser", arr[r].IDUser);
		elemrow.setAttribute("UserFIO", arr[r].UserNameS);
		elemrow.onclick = row_user_click;

		elemrow.id = "ID-" + arr[r].IDUser;

		win_user_list_grid.append(elemrow);

        elem = document.createElement('div');		  
        elem.className = 'grid-td';
        elem.innerHTML = arr[r].UserNameS;
        elemrow.append(elem);

        elem = document.createElement('div');		  
        elem.className = 'grid-td';
        elem.innerHTML = arr[r].ProfName;
        elemrow.append(elem);

        elem = document.createElement('div');		  
        elem.className = 'grid-td';
        elem.innerHTML = arr[r].OfName;
        elemrow.append(elem);
      };
    };
};

function row_user_click(){
	IDUser = this.getAttribute("IDUser");
	Edit_ID = this.getAttribute("IDUser");
	Edit_FIO = this.getAttribute("UserFIO");
	elements = win_user_list_grid.querySelectorAll(".grid-tr");
	Elem_KUR = null;
	for (let i= 0; i< elements.length; i++){
		element = elements[i];
		vID = element.getAttribute("IDUser"); 
		if (vID == IDUser) {
			set_kur(element, "1");
		} else if (element.getAttribute("SetKur") == "1") {
			set_kur(element, "0");	
		};		
	};
};

function set_kur(element, zkur){
	element.setAttribute("SetKur", zkur);
	if (zkur == "1"){
		element.classList.add('elem_kur');

		
  		Elem_KUR = element;
	} else {
      	element.classList.remove('elem_kur');
	};
};



function FERR_GetUserList(str, param){
	alert ('Ошибка')
	return;
};

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function KeyADDUserSave_click(){
	let fio = win_user_edit.querySelector('[name="fio"]');	
	let prof = win_user_edit.querySelector('[name="prof"]');	
	let offi = win_user_edit.querySelector('[name="offi"]');		
	let login = win_user_edit.querySelector('[name="login"]');		
	let password = win_user_edit.querySelector('[name="password"]');		
	let status = win_user_edit.querySelector('[name="status"]');		
	let date_birth = win_user_edit.querySelector('[name="date_birth"]');		
	let date_begin = win_user_edit.querySelector('[name="date_begin"]');		

	let fio_v = fio.value;
	let prof_v = prof.value;	
	let offi_v = offi.value;		
	let login_v = login.value;		
	let password_v = password.value;		
	let status_v = status.value;		
	let date_birth_v = date_birth.value;		
	let date_begin_v = date_begin.value;		

	let LFormDate = new FormData;
    if (Edit_Reg == "ADD") {
	   	LFormDate.append('fio', fio_v);
		LFormDate.append('prof', prof_v);
		LFormDate.append('offi', offi_v);
		LFormDate.append('login', login_v);
		LFormDate.append('password', password_v);
		LFormDate.append('status', status_v);
		LFormDate.append('date_birth', date_birth_v);
		LFormDate.append('date_begin', date_begin_v);
        SendData('../fphp/work/AddUser.php', LFormDate, FOK_AddUser, '', FERR_AddUser);
	};
    if (Edit_Reg == "EDIT") {
		LFormDate.append('VID', GIDUser);
		LFormDate.append('VLogin', GUserLogin);
    	LFormDate.append('VSession', GSession);
		LFormDate.append('VFunction', "UdUser");
		LFormDate.append('VMethod', "SET");

		LFormDate.append('VUserName', fio_v);
		LFormDate.append('VUserStatus', status_v);
		LFormDate.append('VUserOfficeID', offi_v);
		LFormDate.append('VUserProfID', prof_v);
		LFormDate.append('VUserDateBirth', date_birth_v);
		LFormDate.append('VUserDateBegin', date_begin_v);
		LFormDate.append('VSelID', Edit_ID);
    	SendData('../fphp/phpsql.php', LFormDate, FOK_AddUser, '', FERR_AddUser);
	};
};

function FOK_AddUser(str, param){
	const arr = JSON.parse(str);
    if (arr[0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };
//    alert ('Удача, кол-во записей - ' + arr[0][1]);     
	work_get_userlist();
};

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

function KeyShowMO_click(){
	if ((Edit_FIO == '') || (Edit_ID == '')) {
		alert("Не выбран персонал");
		return;
	};

	VisibleWin(win_list, win_showmo_list);


	let Zag = win_showmo_list.querySelector(".wmain_zag");
	Zag.innerHTML = 'Список МО персонала "' + Edit_FIO + '"';

	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
	LFormDate.append('VLogin', GUserLogin);
    LFormDate.append('VSession', GSession);
	LFormDate.append('VFunction', "ShowMOList");
	LFormDate.append('VMethod', "GET");
	LFormDate.append('VSelID', Edit_ID);
  	SendData('../fphp/phpsql.php', LFormDate, FOK_KeyShowMO_click, '', FERR_AddUser);
};

function FOK_KeyShowMO_click(str, param){

  	const arr = JSON.parse(str);
    if (arr[0][0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };

    grid_del_row(elem_grid_list_showmo);
    
	let elem = null;
    let countsql = arr.length;
    if (countsql == 1){
		let cr = arr[0].length;
	  	if (cr > 1) {
      		for (let r = 1; r < arr[0].length; r++) {
        		let elemrow = document.createElement('div');
        		elemrow.className = "grid-tr";
				elemrow.setAttribute("IDMOReestr", arr[0][r].IDMOReestr);
				//elemrow.onclick = row_user_click;
    	        elem_grid_list_showmo.append(elemrow);

	        	elem = document.createElement('div');		  
    	    	elem.className = 'grid-td_mo';
        		elem.innerHTML = arr[0][r].MOTName;
        		elemrow.append(elem);

	        	elem = document.createElement('div');		  
    	    	elem.className = 'grid-td_mo';
        		elem.innerHTML = arr[0][r].MOReDateFrom;
        		elemrow.append(elem);

		       	elem = document.createElement('div');		  
        		elem.className = 'grid-td_mo';
        		elem.innerHTML = arr[0][r].MOReDateTo;
	        	elemrow.append(elem);

    	    	elem = document.createElement('div');		  
        		elem.className = 'grid-td_mo';
        		elem.innerHTML = arr[0][r].UserNameS + "(" + arr[0][r].MOReDateInser + ")";
	        	elemrow.append(elem);
		    };
    	};
	};
};	
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function KeyGoMainMenu_click(){
	let params = {VGIDUser: GIDUser, 
		         VGUserFIO: GUserFIO, 
				 VGLogin: GUserLogin,
				 VGSession: GSession};
    postToSameTab("workindex.php", params);
};



function FERR_AddUser(str, param){
	alert ('Ошибка')
	return;
};	


//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function work_getmslist(){
//   alert ('Введите логин');
   

/*

  let ElemLogin = WMIdent.querySelector('#WMIKS_LoginText');
  let ElemPassword = WMIdent.querySelector('#WMIKS_PasswordText');

  let TextLogin = ElemLogin.value.trim();
  let TextPassword = ElemPassword.value.trim();

//  TextLogin = 'Login';  
//   TextPassword = 'Password';

  if (TextLogin == ''){
    alert ('Введите логин');
    return;
  };
  if (TextPassword == ''){
		alert('Введите пароль');
		return;
	};
    */

	let LFormDate = new FormData;
	LFormDate.append('VID', GIDUser);
     
  SendData('../fphp/work/GetMsList.php', LFormDate, FunNLOK, '', FunNLError);
};

function FunNLOK(str, param){
 //   alert ('Удача - ' + str); 
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
};

function FunNLError(str, param){
	alert ('Ошибка')
	return;
};
