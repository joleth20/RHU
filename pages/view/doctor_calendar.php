<style>
body{background:#E9E9E9;margin:0;padding:0;width:100%;height:100%;font-family: 'Roboto', sans-serif;-moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;}
a{color:white;text-decoration:none;}
#app{width:400px;margin:auto;margin-top:60px;position:relative;}
#calendar{overflow:hidden;background:#2980b9;height:500px;width:100%;box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25), 0px 0px 2px rgba(0, 0, 0, 0.125);}
#header{width:100%;height:30px;color:white;margin-top:5px;text-align:center;z-index:200;}
#header i{width:19%;}
#header p{width:43%;}
#header i, #header p, #header div{display:inline-block;font-size:19px;}
#header > div{width:19%;}
.fa-calendar-o{position:relative;top:-13px;cursor:pointer;}
.fa-calendar-o:before{position:absolute;left:0;line-height:18px;font-size:27px;}
.fa-calendar-o span{position:absolute;font-size:13px;line-height:20px;font-weight:600;left:5px;font-family: 'Roboto', sans-serif;}


ul{list-style:none;}
#dates{width:100%;padding:10px 8px;}
#dates p{color:rgba(189, 195, 199, 0.6);}
#dates > div{width:14%;float:left;text-align:center;color:white;}
#dates > div ul{min-height:300px;width:100%;margin:0;padding:0;}
#dates > div > ul > li{margin-top:15%;width:50px;height:50px;cursor:pointer;border-radius:50%;line-height:50px;}
#dates li:hover{background:rgba(189, 195, 199, 0.2);transition: all 0.3s ease-in-out;-o-transition: all 0.3s ease-in-out;-moz-transition: all 0.3s ease-in-out; -webkit-transition: all 0.3s ease-in-out; -ms-transition: all 0.3s ease-in-out;}
#arrows{float:left;width:100%;height:30px;font-size:15px;color:white;padding-top:30px;text-align:center;}
#arrows i{width:30px;height:30px;line-height:30px;cursor:pointer;border-radius:50%;padding:5px;}
#arrows i:active{background:rgba(189, 195, 199, 0.2)}
#arrows > i{float:left;margin-left:15px;}
#arrows i:nth-child(2n){float:right;margin-right:15px;}
.today{background:rgba(189, 195, 199, 0.1);}
.warning{float:left;color:white;font-size:14px;font-weight:300;position:absolute;bottom:0;padding:10px 20px;}

#entries{float:left;background:white;width:100%;max-width:400px;min-height:50px;max-height:250px;overflow-y:scroll;z-index:-1;box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25), 0px 0px 2px rgba(0, 0, 0, 0.125);}
.contain_entries{padding:20px;}
#entries #entries-header p{padding:0;margin:0;}
#entries #entries-header{width:100%;border-bottom:1px solid #E0E0E0;padding-bottom:20px;}
.rotate{transform:rotate(45deg);-webkit-transform: rotate(45deg);}
.entryDay{font-size:20px;font-weight:500;color:#555;}
.currday{font-size:15px;font-weight:300;color:#777;}

/* add entry form */
#add_entry{position:relative;z-index:50;background:#ffffff;height:400px;width:400px;top:40px;display:none;}
.enter_entry{width:100%;height:50px;background:#2980b9;}
.enter_entry > input{outline:none !important;border:none;max-width:65%;height:30px;font-size:20px;background:transparent;padding:0px 30px;color:#fff;}
.enter_entry > span{width:40%;padding:20px 13px;color:white;cursor:pointer;}

.enter_entry > input::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color: #fff;
}
.enter_entry > input:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color: #fff;
   opacity: 1;
}
.enter_entry > input::-moz-placeholder { /* Mozilla Firefox 19+ */
   color: #fff;
   opacity: 1;
}
.enter_entry > input:-ms-input-placeholder { /* Internet Explorer 10-11 */
   color: #fff;
}
.entry_details{width:100%;height:100%;background:#fff;}
.entry_details > div{padding:0px 30px;}
.entry_info{width:100%;border-bottom:1px solid #E0E0E0;min-height:40px;padding:20px 0px;}
.entry_info2{width:100%;border-bottom:1px solid #E0E0E0;height:40px;padding-bottom:20px;}
.entry_info i, .entry_info2 i{font-size:25px;color:#B6B6B6;line-height:60px;vertical-align:middle;margin-right:20px;}
.entry_info p, .entry_info2 p{line-height:60px;margin:0;padding:0;display:inline-block;width:50%;}
.entry_info2 input{border:none;font-size:16px;width:85%;}
.entry_info2 textarea{border:none;font-size:16px;width:85%;resize:none;margin-top:20px;font-family: 'Roboto', sans-serif;height:35px;}
.entry_info2 input:focus{outline:none;border:none;}
.entry_info2 textarea:focus{outline:none;border:none;}
#select_hour{margin-left:40px;line-height:30px;width:auto;}
#hour{float:right;line-height:35px;text-align:right;}
#enter_hour{padding:0;margin:0;width:20%;padding:5px;border:1px solid #CACACA;}
.fa-pencil{font-size:18px !important;margin-top:-40px;}
.fa-circle{font-size:18px !important;line-height:20px !important;}
.fa-image{font-size:18px !important;line-height:30px !important;float:left;}
#defColor{width:89%;}
.colors{padding-top:0px;}
.colors > div{margin-left:35px;}
.colors > div span i{cursor:pointer;}
.colors > div span i:active{color:#000;}
#blue{color:#2980b9;}
#red{color:#DB1B1B;}
#green{color:#8BB929;}
#yellow{color:#E4F111;}
#purple{color:#8129B9;}
#gray{color:#666666;}
.first{padding-bottom:10px !important;}
.second{min-height:40px !important;height:auto;}
#entry-img{width: 0.1px;height: 0.1px; opacity: 0; overflow: hidden; position: absolute; z-index: -1;}
#for_img{float:left;max-width:70%;max-height:30px;line-height:30px;cursor:pointer;overflow:hidden;}
#for_img:active{background:#EFEFEF;}
#remove_img{float:right;line-height:30px;font-size:15px;color:#888;cursor:pointer;display:none;}

/* toggle */
input[type='checkbox'] {display: none; cursor: pointer; }
input[type='checkbox']:focus,
input[type='checkbox']:active {outline: none; }
input[type='checkbox'] + label {cursor: pointer; display: inline-block; position: relative; padding-left: 25px; margin-right: 10px; color: #0b4c6a; }
input[type='checkbox'] + label:before,
input[type='checkbox'] + label:after {content: ''; font-family: helvetica; display: inline-block; width: 18px; height: 18px; left: 0; bottom: 0; text-align: center; position: absolute; }
input[type='checkbox'] + label:before {background-color: #fafafa; -moz-transition: all 0.3s ease-in-out; -o-transition: all 0.3s ease-in-out; -webkit-transition: all 0.3s ease-in-out; transition: all 0.3s ease-in-out; }
input[type='checkbox'] + label:after {color: #fff; }
input[type='checkbox']:checked + label:before {-moz-box-shadow: inset 0 0 0 10px #158EC6; -webkit-box-shadow: inset 0 0 0 10px #158EC6; box-shadow: inset 0 0 0 10px #158EC6; }
input[type='checkbox'] + label:before {-moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; }
input[type='checkbox'] + label:hover:after, input[type='checkbox']:checked + label:after {content: "\2713"; line-height: 18px; font-size: 14px; }
input[type='checkbox'] + label:hover:after {color: #c7c7c7; }
input[type='checkbox']:checked + label:after, input[type='checkbox']:checked + label:hover:after {color: #fff; }

/*Toggle Specific styles*/
input[type='checkbox'].toggle {display: inline-block; -webkit-appearance: none; -moz-appearance: none; appearance: none; width: 55px; height: 28px; background-color: #C0C0C0; position: relative; -moz-border-radius: 30px; -webkit-border-radius: 30px; border-radius: 30px; -moz-transition: all 0.2s ease-in-out; -o-transition: all 0.2s ease-in-out; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out; float:right; margin-top:18px; }
input[type='checkbox'].toggle:hover:after {background-color: #ffffff; }
input[type='checkbox'].toggle:after {content: ''; display: inline-block; position: absolute; width: 24px; height: 24px; background-color: #F2F2F2; top: 2px; left: 2px; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; -moz-transition: all 0.2s ease-in-out; -o-transition: all 0.2s ease-in-out; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out; }
input[type='checkbox']:checked.toggle {-moz-box-shadow: inset 0 0 0 15px #2980b9; -webkit-box-shadow: inset 0 0 0 15px #2980b9; box-shadow: inset 0 0 0 15px #2980b9; }
input[type='checkbox']:checked.toggle:after {left: 29px; background-color: #fff; }

/* open entry */
#open_entry{position:relative;z-index:50;background:#ffffff;height:520px;width:400px;top:-40px;display:none;position:relative;}
.entry_img{width:100%;height:300px;background:#2980b9;overflow:hidden;}
.entry_img img{opacity:0.7}
.overlay{width:100%;height:300px;position:absolute;z-index:100;color:white;background: -moz-linear-gradient(top,  rgba(30,87,153,0) 0%, rgba(0,0,0,0.5) 100%); background: -webkit-linear-gradient(top,  rgba(30,87,153,0) 0%,rgba(0,0,0,0.5) 100%); background: linear-gradient(to bottom,  rgba(30,87,153,0) 0%,rgba(0,0,0,0.5) 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#001e5799', endColorstr='#80000000',GradientType=0 ); }
.overlay > div{float:left;width:90%;height:87%;padding:20px;}
.overlay p{float:left;width:100%;margin-top:60%;}
.overlay span{float:left;width:100%;line-height:25px;}
#entry_title{font-size:25px;}
#entry_times{font-size:15px;font-weight:300;}
.openedEntry{padding:10px 0px !important;}
.openedEntry > div{line-height:40px;padding-left:20px !important;padding-right:20px !important;border:none !important;}
.noteDiv{height:80px !important;overflow:hidden;padding-top:20px !important;}
.noteDiv > div{line-height:20px !important;}
.openedEntry .fa-map-marker{margin-right:25px !important;}
.openedEntry i{font-size:25px !important;color:#555;margin-right:20px;padding-top:10px !important}
.openedEntry span{color:#999;}
#note{color:black !important;}

/* entry list */
.no-entries{width:100%;text-align:center;padding:15px 0px;}
.no-entries i{font-size:35px;color:#888;width:100%;padding-bottom:20px;}
.no-entries span{font-size:25px;color:#888;width:100%;font-weight:300;font-style:italic;}
.entry{width:100%;border-bottom:1px solid #E0E0E0;height:40px;padding:10px 0px;}
.entry p{margin:0;}
.entry > div{border-left:4px solid #2980b9;height:40px;padding-left:20px;}
.entry_left{float:left;width:80%;cursor:pointer;}
.entry_event{line-height:20px;font-weight:500;color:#555;height:20px;}
.entry_time{line-height:20px;font-weight:300;color:#888;font-size:15px;}
.delete_entry{float:left;width:20%;line-height:40px;text-align:center;font-size:25px;color:#888;}
.delete_entry i{width:30px;height:30px;line-height:30px;cursor:pointer;border-radius:50%;padding:5px;}
.delete_entry i:active{background:rgba(189, 195, 199, 0.2)}

/* Menu */
.fa-bars{cursor:pointer;}
#menu{width:100%;height:100%;position:absolute;background:rgba(0,0,0,0.4);z-index:100;overflow:hidden;display:none;}
#menu-content{width:65%;background:white;float:left;height:100%;display:none;}
#click-close{float:right;width:35%;height:100%;cursor:pointer;}
.madeBy{width:100%;height:200px;position:relative;background:#2980b9;color:white;}
.madeOverlay{width:100%;position:absolute;bottom:10px;}
.madeOverlay span{float:left;width:100%;margin-left:15px;margin-bottom:5px;font-weight:300;}
#madeName{font-weight:400;font-size:20px;}
#madeInfo{font-size:14px;}
#madeWeb{font-size:14px;display:inline-block;width:auto;}
#madeWeb:hover{text-decoration:underline;}

#ignoreOverflow{position:absolute;bottom:-25px;right:0;}
/* material button */
@-webkit-keyframes ink-visual-show {
  from {
    opacity: 1;
    -webkit-transform: scale(0);
            transform: scale(0);
  }
  to {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
}

@keyframes ink-visual-show {
  from {
    opacity: 1;
    -webkit-transform: scale(0);
            transform: scale(0);
  }
  to {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
}
@-webkit-keyframes ink-visual-hide {
  to {
    opacity: 0;
  }
}
@keyframes ink-visual-hide {
  to {
    opacity: 0;
  }
}
button {
  -webkit-transition-duration: 0.2s;
          transition-duration: 0.2s;
  -webkit-transition-timing-function: cubic-bezier(0.25, 0.5, 0.5, 1);
          transition-timing-function: cubic-bezier(0.25, 0.5, 0.5, 1);
  position: relative;
  padding: 0;
  height: auto;
  border: none;
  border-radius: 2px;
  outline: none;
  line-height: 60px;
  text-transform: uppercase;
  z-index:200;
}
button:active {
  -webkit-transition-duration: 0.1s;
          transition-duration: 0.1s;
}
button .btn {
  position: relative;
  padding: 0px 8px;
  z-index: 2;
}
button .ink-visual-container {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  border-radius: 2px;
  z-index: 1;
}
button .ink-visual-container .ink-visual-static {
  position: static;
  width: 100%;
  height: 100%;
  overflow: hidden;
  border-radius: 2px;
}
button .ink-visual-container .ink-visual {
  -webkit-animation: ink-visual-show 0.25s cubic-bezier(0.25, 0.5, 0.5, 1);
          animation: ink-visual-show 0.25s cubic-bezier(0.25, 0.5, 0.5, 1);
  -webkit-animation-fill-mode: both;
          animation-fill-mode: both;
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
  opacity: 1;
  z-index: -1;
}
button .ink-visual-container .ink-visual.hide {
  -webkit-animation: ink-visual-show 0.25s cubic-bezier(0.25, 0.5, 0.5, 1), ink-visual-hide 0.5s cubic-bezier(0.25, 0.5, 0.5, 1);
          animation: ink-visual-show 0.25s cubic-bezier(0.25, 0.5, 0.5, 1), ink-visual-hide 0.5s cubic-bezier(0.25, 0.5, 0.5, 1);
}
button .ink-visual-container .ink-visual.hide.shown {
  -webkit-animation: ink-visual-show 0.25s cubic-bezier(0.25, 0.5, 0.5, 1), ink-visual-hide 0.15s cubic-bezier(0.25, 0.5, 0.5, 1);
          animation: ink-visual-show 0.25s cubic-bezier(0.25, 0.5, 0.5, 1), ink-visual-hide 0.15s cubic-bezier(0.25, 0.5, 0.5, 1);
}
button.float {
  -webkit-transition-property: box-shadow, background;
  transition-property: box-shadow, background;
  background-color: #40b31a;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25), 0px 0px 2px rgba(0, 0, 0, 0.125);
  color: white;
}
button.float:hover {
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.25), 0px 0px 4px rgba(0, 0, 0, 0.125);
  background-color: #5dbe3c;
}
button.float:active {
  box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.25), 0px 0px 1px rgba(0, 0, 0, 0.125);
  background-color: #3ba518;
}
button.float:active {
  background-color: #5dbe3c;
}
button.float .ink-visual {
  background-color: #3ba518;
}
button.float {
  border-radius: 50%;
  width: 60px;
  height: 60px;
  font-size: 40px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25), 0px 0px 2px rgba(0, 0, 0, 0.125);
  background-color: #333;
  float:right;
  cursor:pointer;
  margin-right:20px;
  margin-top:5px;
}
button.float:hover {
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.25), 0px 0px 4px rgba(0, 0, 0, 0.125);
  background-color: #333;
}
button.float:active {
  box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.25), 0px 0px 1px rgba(0, 0, 0, 0.125);
  background-color: #555;
}
button.float:active {
  background-color: #333;
}
button.float .ink-visual-container {
  border-radius: 50%;
  -webkit-clip-path: circle();
          clip-path: circle();
}
button.float .ink-visual-static {
  border-radius: 50%;
}
button.float .ink-visual {
  background: #555;
}
</style>
<head>
  <script src="https://use.fontawesome.com/484df5253e.js"></script>
</head>
<body>
	<div id="app"></div>
</body>
