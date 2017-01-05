<?php
$config['site']['domain'] = 'TableSavvy';
$config['meta']['keywords'] = 'Chicago Dining, Last Minute Restaurant Reservations,TableSavvy';
$config['meta']['description'] = 'TableSavvy offers 30% off last minute restaurant reservations throughout Chicago';
		
class ConstUserFriendStatus
{
    const Pending = 1;
    const Approved = 2;
    const Rejected = 3;
}
class ConstUserTypes
{
    const Admin = 1;
    const User = 2;
    const Company = 3;
}
$config['site']['is_admin_settings_enabled'] = true;
?>