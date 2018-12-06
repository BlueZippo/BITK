<?php

if (mail('celsomalacasjr@gmail.com', 'Test', 'Test', "From: admin@platstackt.com\r\n"))
{
	echo "sent";
}
else
{
	echo "not sent";
}


?>