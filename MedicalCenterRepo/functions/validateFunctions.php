 <?php   
    // Function to test input
    function test_input($data){
        $data = trim($data);// Trim whitespace
        $data = stripslashes($data);// Remove HTML and PHP tags
        $data = htmlspecialchars($data);// Escape special characters to prevent SQL injection
        return $data;
    }
    
    // Function to validate name
    function validateName($name) {
        $nameRegex = '/^[a-zA-Z]+$/';
        return preg_match($nameRegex, $name);
    }
    
    // Function to validate email
    function validateEmail($email) {
        $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
        return preg_match($emailRegex, $email);
    }

    // Function to validate phone
    function validatePhone($phone) {
        $lebanesePhoneRegex = '/^\d{8}$/';
        /* $lebanesePhoneRegex = '/^(?:\+961|0\d{1,2}) \d{3} \d{3}$/'; */
        return preg_match($lebanesePhoneRegex, $phone);
    }

    // Function to validate subject
    function validateSubjectStructure($subject) {
        $subjectRegex = '/^.{1,}$/';
        return preg_match($subjectRegex, $subject);
    }

?>