



//create a new WebSocket object.
var wsUri = "ws://localhost:9000/"; 	
websocket = new WebSocket(wsUri); 

websocket.onopen = function(ev) { // connection is open 
	// msgBox.append('<div class="system_msg" style="color:#bbbbbb">Welcome to my "Demo WebSocket Chat box"!</div>'); //notify user
	//prepare json data
	console.log('Socket connected');

}
// Message received from server
websocket.onmessage = function(ev) {
	var response 		= JSON.parse(ev.data); //PHP sends Json data
	
	var res_type 		= response.type; //message type
	var gui_tu 			= response.gui_tu; //message text
	var gui_toi 		= response.gui_toi; //user name
	var message 		= response.message;
	console.log(response);
	switch(res_type){
		case 'system':
			console.log(message);
			// msgBox.append('<div style="color:#bbbbbb">' + message + '</div>');
			break;
		case 'thong_bao_ket_ban':


	}
	
};

websocket.onerror	= function(ev){ console.log('Error Occurred: ' + ev.data); }; 
websocket.onclose 	= function(ev){ console.log('Connection Closed'); }; 
// Message send button


