<?php
define('DB_NAME','C:/xampp/htdocs/project exercises/Projects/CRUD/data/db.txt');
function seed() {
    $data = array(
        array(
            'id' => 1,
            'fname'=>'Ahmed',
            'lname'=>'Nawajish',
            'roll'=>11,

        ), array(
            'id' => 2,
            'fname'=>'Cupid',
            'lname'=>'Chakma',
            'roll'=>12,

        ), array(
            'id' => 3,
            'fname'=>'Ripon',
            'lname'=>'Chakma',
            'roll'=>13,

        ),array(
            'id' => 4,
            'fname'=>'John',
            'lname'=>'Rozario',
            'roll'=>14,

        )
    );
    $serializeData = serialize($data);
    file_put_contents(DB_NAME, $serializeData,LOCK_EX);
}

function generate_report() {
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    ?>

    <table>
        <tr>
            <th>Name</th>
            <th>Roll</th>
            <th>Action</th>
        </tr>
        <?php
        foreach($students as $student) {
            ?>  
            <tr>
                <td><?php printf('%s %s', $student['fname'],$student['lname'])?></td>
                <td><?php printf('%s', $student['roll'])?></td>
                <td><?php printf('<a href="?task=edit&id=%s">Edit</a> | <a class="delete" href="?task=delete&id=%s">Delete</a>',(string)$student['id'], (string)$student['id'])?></td>
            </tr>
            <?php
        } 
        ?>
    </table>
    <?php
}

function addStudent($fname, $lname, $roll) {
    $found = false;
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach($students as $student) {
        if($student['roll'] == $roll) {
            $found = true;
            break;
        }
    }
    if(!$found) {
    $newID = getNewID($students);
    $student = array (
        'id'    => $newID,
        'fname' => $fname,
        'lname' => $lname,
        'roll'  => $roll

    );
    array_push( $students, $student );
    $serializeData = serialize( $students );
    file_put_contents( DB_NAME, $serializeData,LOCK_EX );
    return true;
    }
    return false;
}
function getStudent( $id ) {
    $serializeData = file_get_contents( DB_NAME );
    $students = unserialize( $serializeData );
    foreach( $students as $student_1 ) {
        if( $student_1['id'] == $id ) {
            return $student_1;
        }
    }
    return false;
}

function updateStudent($id,$fname, $lname, $roll) {
    $found = false;
    $serializeData = file_get_contents( DB_NAME );
    $students = unserialize( $serializeData );
    foreach( $students as $student_1 ) {
        if( $student_1['roll'] == $roll && $student_1['id'] != $id) {
            $found  = true;
            break;
        }
    }
    if( ! $found ) {
        $students[ $id-1 ][ 'fname' ] = $fname;
        $students[ $id-1 ][ 'lname' ] = $lname;
        $students[ $id-1 ][ 'roll' ]  = $roll;
        $serializeData = serialize($students);
        file_put_contents(DB_NAME, $serializeData, LOCK_EX);
        return true;
    }

}
function deleteStudent($id) {
    $serialziedData = file_get_contents( DB_NAME );
	$students       = unserialize( $serialziedData );

	foreach ( $students as $offset=>$student_1 ) {
		if ( $student_1['id'] == $id ) {
			unset($students[$offset]);
		}

	}
	$serializedData               = serialize( $students );
	file_put_contents( DB_NAME, $serializedData, LOCK_EX );
}

function printRaw() {
    $serializeData = file_get_contents( DB_NAME );
    $students = unserialize( $serializeData );
    print_r($students);
}

function getNewID($students) {
    $maxId = max(array_column($students, 'id'));
    return $maxId+1;
}
