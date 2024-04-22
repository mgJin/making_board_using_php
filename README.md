1. 별도의 라이브러리 도움없이 이것저것 만들어보고 싶어서 진행한 프로젝트입니다.
2. 게시판, 로그인, 관리자페이지, 라우팅, 행동별로 퍼미션을 확인하는 미들웨어를 구현하였습니다.
3. DataERD


  ![php_making_board_ERD_Photo](https://github.com/mgJin/making_board_using_php/assets/97017695/75d1f1ba-be98-4992-804f-6b46d82952b0)

4. permission-role table
    role과 퍼미션들을 각각 만들고 이를 permisson_role table 에서 N:N 으로 매칭을 시켜줍니다. role의 pk를 멤버의 Column중 하나로 봅니다.
    조회를 할때에는 member의 role_id를 알아낸 후 permission_role table에서 role_id로 해당 role에 맞는 permission 들을 조회할 수 있습니다.
5. 라우팅

   

![runFunction](https://github.com/mgJin/making_board_using_php/assets/97017695/84ea681d-ed4e-4536-a175-c3ddaf8643aa)
![route](https://github.com/mgJin/making_board_using_php/assets/97017695/5ca87ef1-b9e7-4e7d-876e-8a66271d6ec6)

runFunction 에서는 들어온 url을 사용할 수 있도록 가공한 후, preg_match 를 통해 라우트의 배열 내용 중 일치하는 것이 있는지 확인합니다. 파라미터로 게시판의 pk를 넘기는 것이 아니라 uri안에 담아서 넘겨주고 싶었기에 preg_match와 정규식을 활용하였습니다. 일치하는 것을 찾은 후 해당 함수를 부를 수 있는 call_user_func_array() 를 통해 실행시킵니다.RESTful API 를 구현하고 싶었기에 method를 넣어 구분을 하도록 하였습니다. 

6. 퍼미션 미들웨어
    index 위에 미들웨어를 두어 들어오는 URL 별로 퍼미션들을 조회하여 해당 유저가 요청한 행동을 할 수 있는지 구분할 수 있도록 하였습니다.

7. 관리자 페이지



https://github.com/mgJin/making_board_using_php/assets/97017695/6acc7600-0658-4315-afa7-6c507cf66c56

Role 과 유저와 게시판들을 관리할 수 있는 관리자 페이지입니다.

Role 을 조회, 추가, 수정, 삭제 할 수 있습니다.
유저에 대한 정보조회와 유저의 role 수정, 유저 삭제를 할 수 있습니다.
게시판 정보조회,삭제를 할 수 있습니다.

