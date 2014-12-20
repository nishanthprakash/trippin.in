<?php
function _iscurlsupported(){
if (in_array ('curl', get_loaded_extensions())) {
return true;
}
else{
return false;
}
}
if (_iscurlsupported()) echo "cURL is supported"; else echo "cURL is NOT supported";

?>