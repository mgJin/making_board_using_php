<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Click on Hover Area</title>
<style>
/* CSS로 hover 영역 스타일 정의 */
.hover-area {
    width: 200px;
    height: 200px;
    background-color: lightgray;
    cursor: pointer;
}
</style>
</head>
<body>
<!-- hover 영역을 표시하는 div 요소 -->
<div id="hoverArea" class="hover-area">Hover Area</div>

<script>
// JavaScript로 hover 영역 클릭 이벤트 추가
const hoverArea = document.getElementById('hoverArea');

hoverArea.addEventListener('mousedown', function(event) {
    // 클릭 이벤트 발생 시 동작할 코드 작성
    console.log('Clicked on hover area');
});
</script>
</body>
</html>
