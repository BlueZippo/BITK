<?php

if (mail('celsomalacasjr@gmail.com', 'Test', 'Test', "From: admin@platstackt.com\r\n"))
{
	echo "sent to celsomalacasjrg@gmail.com<br />";
}
else
{
	echo "not sent";
}

if (mail('cmalacas@rocketsource.co', 'Test', 'Test', "From: admin@platstackt.com\r\n"))
{
	echo "sent to cmalacas@rocketsource.co<br />";
}
else
{
	echo "not sent";
}

if (mail('michael.tiano@gmail.com', 'Test', 'Test', "From: admin@platstackt.com\r\n"))
{
	echo "sent to michael.tiano@gmail.com<br />";
}
else
{
	echo "not sent";
}

?>