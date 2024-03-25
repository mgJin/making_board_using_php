<style>
.container {
    display: flex;
    justify-content: space-around;
    align-items: flex-start;
}

.box {
    width: 200px;
    padding: 20px;
    border: 2px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.box:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

h2 {
    margin-bottom: 10px;
    font-size: 18px;
}

input[type="radio"],
input[type="checkbox"] {
    margin-right: 5px;
    transform: translateY(2px);
}

label {
    font-size: 16px;
}

button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

</style>

<div class="container">
    <div class="box">
        <h2>라디오 버튼</h2>
        <input type="radio" id="radio1" name="radioGroup">
        <label for="radio1">옵션 1</label><br>
        <input type="radio" id="radio2" name="radioGroup">
        <label for="radio2">옵션 2</label><br>
        <input type="radio" id="radio3" name="radioGroup">
        <label for="radio3">옵션 3</label><br>
    </div>
    <div class="box">
        <h2>체크박스</h2>
        <input type="checkbox" id="checkbox1" name="checkbox1">
        <label for="checkbox1">옵션 1</label><br>
        <input type="checkbox" id="checkbox2" name="checkbox2">
        <label for="checkbox2">옵션 2</label><br>
        <input type="checkbox" id="checkbox3" name="checkbox3">
        <label for="checkbox3">옵션 3</label><br>
        <input type="checkbox" id="checkbox4" name="checkbox4">
        <label for="checkbox4">옵션 4</label><br>
        <input type="checkbox" id="checkbox5" name="checkbox5">
        <label for="checkbox5">옵션 5</label><br>
        <input type="checkbox" id="checkbox6" name="checkbox6">
        <label for="checkbox6">옵션 6</label><br>
    </div>
</div>
<button>버튼 1</button>
<button>버튼 2</button>
<button>버튼 3</button>
