/*********************  Declare ************************* */
let win_user_list = document.querySelector("#user_list");
let win_user_list_grid = document.querySelector("#user_list_gird");
let win_user_edit = document.querySelector("#user_edit");
let win_user_edit_prof = document.querySelector("#UserEditProf");
let win_user_edit_offi = document.querySelector("#UserEditOffi");
let Elem_KUR = null;
let RegEdit = "ADD";
let IDEdit = 0;


win_user_list.classList.remove('delete');
win_user_edit.classList.add('delete');


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


//////////////////////////////////////////////////////////////////////////
function work_get_userlist(){
//    alert ('запуск - '); 

   win_user_list.classList.remove('delete');
   win_user_edit.classList.add('delete');
   user_list_del();


	let LFormDate = new FormData;
	LFormDate.append('VID', LIDUser);
	LFormDate.append('VLogin', LIDUser);
	LFormDate.append('VFunction', "GetSpisUserShot");
	LFormDate.append('VMethod', "GET");
	LFormDate.append('VSearchFIO', "");
	LFormDate.append('VSelID', "");	
     
    SendData('../fphp/phpsql.php', LFormDate, FOK_GetUserList, '', FERR_GetUserList);
};	

//////////////////////////////////////////////////////////////////////////
function work_user_edit(){
    IDUSer = null;
	if (Elem_KUR != null){
		IDUser = Elem_KUR.getAttribute("IDUser");
	};

    if (IDUser < 1) {
  		alert("Персонал не определен")
		return;
	};

	element = win_user_edit.querySelector(".wmain_zag");
	if (element != null){
		element.innerHTML = "Изменить данные персонала"
	}

    win_user_list.classList.add('delete');
    win_user_edit.classList.remove('delete');

	let LFormDate = new FormData;
	LFormDate.append('VID', LIDUser);
	LFormDate.append('VLogin', LIDUser);
	LFormDate.append('VFunction', "GetUserFull");
	LFormDate.append('VMethod', "GET");
	LFormDate.append('VSearchFIO', "");
	LFormDate.append('VSelID', IDUser);	
	IDEdit = IDUser;
     
    SendData('../fphp/phpsql.php', LFormDate, FOK_GetUserFull, '', FERR_GetUserList);
};

function FOK_GetUserFull(str, param){
  	const arr = JSON.parse(str);
    if (arr[0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };
    alert ('Удача, кол-во записей - ' + arr[0][1]);     
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
	RegEdit = "EDIT";
    IDEdit = 0;
};	


function work_user_add(){
	element = win_user_edit.querySelector(".wmain_zag");
	if (element != null){
		element.innerHTML = "Добавить персонал"
	}
    win_user_list.classList.add('delete');
    win_user_edit.classList.remove('delete');
};

function work_user_del(){
    win_user_list.classList.add('delete');
    win_user_edit.classList.remove('delete');
};


///////////////////////////////////////////////////////////////
function user_list_del(){
    let elements =  win_user_list_grid.querySelectorAll(".grid-tr");
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
    alert ('Удача, кол-во записей - ' + arr[0][1]);     

	let elem = null;
    let cr = arr.length;
    if (cr > 1){
      for (let r = 1; r < arr.length; r++) {
        let elemrow = document.createElement('div');
        elemrow.className = "grid-tr";
		elemrow.setAttribute("IDUser", arr[r].IDUser);
		elemrow.onclick = work_user_sel;

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

function work_user_sel(){
	const IDUser = this.getAttribute("IDUser");
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


function FOK_GetProfOffiList(str, param){
	const arr = JSON.parse(str);
    if (arr[0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };
    alert ('Удача, кол-во записей - ' + arr[0][1]);     

	if (param == 'prof'){
		let elemselect = win_user_edit_prof;
	}else{
		let elemselect = win_user_edit_offi;
	};

    let cr = arr.length;
    if (cr > 1){
      for (let r = 1; r < arr.length; r++) {
		let elemopt = document.createElement('option');
		elemopt.text = arr[r][1];
		elemopt.value = arr[r][0];
		//elemopt.selected = true; // Делает этот пункт активным

    	if (param == 'prof'){
	    	win_user_edit_prof.append(elemopt);
	    }else{
			win_user_edit_offi.append(elemopt);
		};
      };
    };
  	if (param == 'prof'){
  		work_get_office_list();
	} else if (param == 'offi'){
		work_get_userlist();
	};	
};


function FERR_GetUserList(str, param){
	alert ('Ошибка')
	return;
};

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
function work_click_save_form(){
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
 	LFormDate.append('fio', fio_v);
	LFormDate.append('prof', prof_v);
	LFormDate.append('offi', offi_v);
	LFormDate.append('login', login_v);
	LFormDate.append('password', password_v);
	LFormDate.append('status', status_v);
	LFormDate.append('date_birth', date_birth_v);
	LFormDate.append('date_begin', date_begin_v);
    if (RegEdit = "ADD") {
      SendData('../fphp/work/AddUser.php', LFormDate, FOK_AddUser, '', FERR_AddUser);
	};
    if (RegEdit = "EDIT") {
		LFormDate.append('VID', LIDUser);
		LFormDate.append('VLogin', LIDUser);
		LFormDate.append('VFunction', "SetUserEdit");
		LFormDate.append('VMethod', "GET");
		LFormDate.append('VID_USER_EDIT', "IDEdit");
    	SendData('../fphp/phpsql.php', LFormDate, FOK_AddUser, '', FERR_AddUser);
	};
};

function FOK_AddUser(str, param){
	const arr = JSON.parse(str);
    if (arr[0][0] != "OK"){
      alert ('Oшибка - ' + arr[0][1]);     
      exit;
    };
    alert ('Удача, кол-во записей - ' + arr[0][1]);     
	work_get_userlist();
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
	LFormDate.append('VID', LIDUser);
     
  SendData('../fphp/work/GetMsList.php', LFormDate, FunNLOK, '', FunNLError);
};

function FunNLOK(str, param){
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
};

function FunNLError(str, param){
	alert ('Ошибка')
	return;
};
