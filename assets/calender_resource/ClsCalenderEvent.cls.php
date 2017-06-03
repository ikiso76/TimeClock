<? 
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//									bGlobalSourcing	[Programmer: Md. Aminul Islam]												//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//		Class: ClsCalenderEvent: Used for Show Calender.																		//
	//				[ Limitation: ]																									//
	//==============================================================================================================================//
	// function ClsCalenderEvent($CalResourceFolderLoc)	[Contstructor]																//
	/*------------------------------------------------------------------------------------------------------------------------------//
		$CalResourceFolderLoc= The Location of the Folder of Calender Resource
	//==============================================================================================================================//
	// function ShowCalImage($TextBoxName,$CalIconName="calendar.gif",$DateFormat="mm-dd-y")										//
	//------------------------------------------------------------------------------------------------------------------------------//
	/*	This Function Takes 3 Parameters(2 Default Initialization):-
		$TextBoxName = The Name of Text Box where date shows.
		$CalIconName = Icon Name of Calender default: calender.gif.
		$DateFormat	 = Date format Default: "mm-dd-y"																				
		----------------------------------------------------------------------------------------------------------------------------
		This function will return Calender Image include Javascript Code.
			"<img src=\"$CalResourceFolder/$CalIconName\" width=\"34\" height=\"21\" style=\"cursor:pointer\" 
								onclick=\"return showCalendar('$TextBoxName', '$DateFormat');\"> 
	//==============================================================================================================================//
	// function CalenderJSCode($TextBoxNames)																						//
	//------------------------------------------------------------------------------------------------------------------------------//
	/*	This Function Takes 1 Parameters:-
		$TextBoxNames = Single or Multiple Textboxes where date will show.
		----------------------------------------------------------------------------------------------------------------------------
		This function will return Javascript Code for Show Calender. (93 Line Code)
	//==============================================================================================================================//
	/*
		Example:- 																													
			//For Successfull image upload function return Files Base Name. otherwise return $UploadFailureMsg
			$CalResourceFolderLoc="class_and_files/calender_resource";
			$ObjCal=new ClsCalenderEvent($CalResourceFolderLoc);	[constructor]

			//Show Javascript Code for Calender
			$TextBoxNames="txtFirstDt";	//Or $TextBoxNames=array("txtFirstDt","txtSecondDt");
			$CalJSCode=$ObjCal->CalenderJSCode($TextBoxNames);
			echo $CalJSCode;
			
			//Show Calender Icon(including JS Code).
			$TextBoxName="txtFirstDt";
			$CalIconName="calendar.gif";
			$DateFormat="mm-dd-y";
			echo $ObjCal->ShowCalImage($TextBoxName,$CalIconName,$DateFormat);
	*/
	//==============================================================================================================================//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	class ClsCalenderEvent
	{
		var $CalResourceFolderLoc;

		function ClsCalenderEvent($CalResourceFolderLocation)
		{
			$this->CalResourceFolderLoc=$CalResourceFolderLocation;
		}
		function ShowCalImage($TextBoxName,$CalIconName="calendar.gif",$DateFormat="mm-dd-y")
		{
			$CalResourceFolder=$this->CalResourceFolderLoc;
			$CalImage="<img src=\"$CalResourceFolder/$CalIconName\" width=\"34\" height=\"21\" style=\"cursor:pointer\" onclick=\"return showCalendar('$TextBoxName', '$DateFormat');\" align=\"absmiddle\"> ";
			return $CalImage;
		}
		function CalenderJSCode($TextBoxNames)
		{
			$AllNewsTable="";
			$CalResourceFolderLoc=$this->CalResourceFolderLoc;			

			$CalJSCode = " <!-- Start of Calender-->	\n";
			$CalJSCode.= " <LINK title='winter' media='all' href=\"$CalResourceFolderLoc/calendar-blue.css\" type=\"text/css\" rel=\"alternate stylesheet\">	\n";
			$CalJSCode.= " <SCRIPT src=\"$CalResourceFolderLoc/calendar.js\" type=\"text/javascript\"></SCRIPT>	\n";
			$CalJSCode.= " <SCRIPT src=\"$CalResourceFolderLoc/calendar-en.js\" type=\"text/javascript\"></SCRIPT>	\n";
			$CalJSCode.= " <SCRIPT language=\"javascript1.2\" type=\"text/javascript\">	\n";
			$CalJSCode.= " var oldLink = null;	\n";
			$CalJSCode.= " // code to change the active stylesheet	\n";
			$CalJSCode.= " function setActiveStyleSheet(link, title)	\n"; 
			$CalJSCode.= " {			\n";
			$CalJSCode.= " 	var i, a, main;	\n";
			$CalJSCode.= " 	for(i=0; (a = document.getElementsByTagName(\"link\")[i]); i++) 	\n";
			$CalJSCode.= " 	{				\n";
			$CalJSCode.= " 		if(a.getAttribute(\"title\")) 		\n";
			$CalJSCode.= " 		{			\n";
			$CalJSCode.= " 			a.disabled = true;		\n";
			$CalJSCode.= " 			if(a.getAttribute(\"title\") == title) a.disabled = false;		\n";
			$CalJSCode.= " 		}			\n";
			$CalJSCode.= " 	}				\n";
			$CalJSCode.= " 	return false;	\n";
			$CalJSCode.= " }					\n";
			
			$CalJSCode.= " setActiveStyleSheet(this, 'winter');	\n";
			
			$CalJSCode.= " function selected(cal, date) 	\n";
			$CalJSCode.= " {		\n";
			$CalJSCode.= "   cal.sel.value = date; // just update the date in the input field.	\n";
			$CalJSCode.= "   //if (cal.sel.id == \"txtjobpostdt\" || cal.sel.id == \"txtlstdtsub\") --if more then one calender used in one page	\n";
			if(is_array($TextBoxNames))
			{
				$CalJSCode.= "   if (";
				foreach($TextBoxNames as $SingleTxtBox)
					$CalJSCode.= "cal.sel.id == \"$SingleTxtBox\" ||";
				$CalJSCode=substr($CalJSCode,0,strlen($CalJSCode)-3);
				$CalJSCode.= ")	\n";
			}
			else		
				$CalJSCode.= " if (cal.sel.id == \"$TextBoxNames\")	\n";		
			$CalJSCode.= " 	cal.callCloseHandler();			\n";
			$CalJSCode.= " }			\n";
			$CalJSCode.= " function closeHandler(cal) {		\n";
			$CalJSCode.= "   cal.hide();  			\n";                      
			$CalJSCode.= " }			\n";
			
			$CalJSCode.= " function showCalendar(id, format) {	\n";
			$CalJSCode.= "   document.getElementById(id).value='';	\n";
			$CalJSCode.= "   var el = document.getElementById(id);	\n";
			$CalJSCode.= "   if (calendar != null) {			\n";
			$CalJSCode.= " 	calendar.hide();                 // so we hide it first.	\n";
			$CalJSCode.= "   } else {		\n";
			$CalJSCode.= " 	var cal = new Calendar(false, null, selected, closeHandler);		\n";
			$CalJSCode.= " 	calendar = cal;                  // remember it in the global var	\n";
			$CalJSCode.= " 	cal.setRange(1900, 2070);        // min/max year allowed.			\n";
			$CalJSCode.= " 	cal.create();			\n";
			$CalJSCode.= "   }			\n";
			$CalJSCode.= "   calendar.setDateFormat(format);    // set the specified date format		\n";
			$CalJSCode.= "   calendar.parseDate(el.value);      // try to parse the text in field		\n";
			$CalJSCode.= "   calendar.sel = el;                 // inform it what input field we use	\n";
			$CalJSCode.= "   calendar.showAtElement(el);        // show the calendar below it			\n";
			
			$CalJSCode.= "   return false;		\n";
			$CalJSCode.= " }			\n";
			
			$CalJSCode.= " var MINUTE = 60 * 1000;	\n";
			$CalJSCode.= " var HOUR = 60 * MINUTE;	\n";
			$CalJSCode.= " var DAY = 24 * HOUR;	\n";
			$CalJSCode.= " var WEEK = 7 * DAY;	\n";
			
			$CalJSCode.= " function isDisabled(date) 	\n";
			$CalJSCode.= " {	\n";
			$CalJSCode.= "   var today = new Date();	\n";
			$CalJSCode.= "   return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;	\n";
			$CalJSCode.= " }	\n";
			
			$CalJSCode.= " function flatSelected(cal, date) {		\n";
			$CalJSCode.= "   var el = document.getElementById(\"preview\");	\n";
			$CalJSCode.= "   el.innerHTML = date;		\n";
			$CalJSCode.= " }		\n";
			
			$CalJSCode.= " function showFlatCalendar() 		\n";
			$CalJSCode.= " {		\n";
			$CalJSCode.=  "   var parent = document.getElementById(\"display\");		\n";
			
			$CalJSCode.= "   var cal = new Calendar(false, null, flatSelected);		\n";
			
			$CalJSCode.= "   // hide week numbers		\n";
			$CalJSCode.= "   cal.weekNumbers = false;		\n";
			
			$CalJSCode.= "   // We want some dates to be disabled; see function isDisabled above		\n";
			$CalJSCode.= "   cal.setDisabledHandler(isDisabled);		\n";
			$CalJSCode.= "   cal.setDateFormat(\"DD, M d\");			\n";
			$CalJSCode.= "   cal.create(parent);			\n";
			$CalJSCode.= "   cal.show();		\n";
			$CalJSCode.= " }			\n";
			$CalJSCode.= " </SCRIPT>		\n";
			$CalJSCode.= " <!-- End of Calender-->	\n";		
		
			return $CalJSCode;
		}
	}
?>