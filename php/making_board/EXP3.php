<script>

    element.addEventListener('click', function() {
        console.log('Outer Event Handler');
        if (someCondition) {
            return;
        }
        element.addEventListener('keyup', function() {
            console.log('Inner Event Handler');
        });
    });
    
    // Outer Event 실행
    
    
    </script>
