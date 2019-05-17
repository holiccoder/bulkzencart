<?php
function sendFile($localFile, $remoteFile, $permision = 0644)
$sftp = ssh2_sftp ( $this->conn );
$sftpStream = @fopen ( 'ssh2.sftp://' . $sftp . $remoteFile, 'w' );
if ( ! $sftpStream ) {
//  if 1 method failes try the other one
if ( ! @ssh2_scp_send ( $this->conn, $localFile, $remoteFile, $permision ) ) {
throw new Exception ( "Could not open remote file: $remoteFile" );
}
else {
return true;
}
}

$data_to_send = @file_get_contents ( $localFile );

if ( @fwrite ( $sftpStream, $data_to_send ) === false ) {
throw new Exception ( "Could not send data from file: $localFile." );
}

fclose ( $sftpStream );
return true;

}