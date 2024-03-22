def solution(coin, cards):
    start_len = len(cards)//3 #시작 할 때의 길이
    sum_goal = len(cards)+1 #목표 합
    current_cards = cards[:start_len] #처음 배열
    max_loop_count = ((len(cards)-start_len)//2)+1 #최대 루프 수

    answer = 0 #최종 답
    for round in range(max_loop_count):#리턴할 때에 answer = round +1 중요중요!!!!!
        
        if(round==max_loop_count-1): #최대 루프에 도달 하면 계산 없이 바로 빠져나오기
            print("최종라운드",round)
            return round
            break
        chkBool = False #일치하는 카드가 나왔는지
        pick_index_1 = 2*round + start_len #index니깐 -1씩 해줘서 이 결과인것
        pick_index_2 = 2*round +1 + start_len
        
        first_card = cards[pick_index_1] #라운드당 첫번째 뽑는 카드
        second_card = cards[pick_index_2] #라운드당 두 번째로 뽑는 카드
        #전략적으로 처음 혹은 두번째 뽑은 카드랑 기존에 있던 것이랑 일치할 때 먼저 제거하는 것이 좋음
        #두개다 유효하다면 라운드 버티기가 중요하니깐 하나만 선택하도록

        #그 다음은 코인을 두 개쓰거나 안쓰거나 인데 . 두개를 쓰는 경우 낭비가 될 수도 있고 아닐 수도 있음
        #이건 분기를 태워보자

        #첫 번째 카드랑 일치하는 경우
        if(coin>0):
            for i in range(len(current_cards)):
                if(sum_goal == (first_card + current_cards[i])):
                    print("FirstPick")
                    current_cards.append(first_card)
                    coin = coin -1
                    print("현재남은 코인은 :",coin)
                    print("현재 라운드: ",round+1)
                    break
            if(coin>0):       
            #두 번째 카드랑 일치하는 경우
                for i in range(len(current_cards)):
                    if(sum_goal == (second_card + current_cards[i])):
                        print("SecondPick")
                        
                        current_cards.append(second_card)
                        coin = coin -1
                        print("현재남은 코인은 :",coin)
                        print("현재 라운드: ",round+1)
                        break
            #현재 목록에 있는 카드 색출해내기 (break를 걸지 말고 count를 한 후에 총 몇턴 버틸 수 있는지 계산 =>다른 카드를 먹어도 되는지 계산)
            for i in range(len(current_cards)):
                for j in range(i+1,len(current_cards)):
                    if(sum_goal == current_cards[i]+current_cards[j]):
                        print("제거될 카드 : ",current_cards[i],current_cards[j])
                        removeA = current_cards[i]
                        removeB = current_cards[j]
                        current_cards.remove(removeA)
                        current_cards.remove(removeB)
                        print("현재 남아있는 카드목록:", current_cards)
                        print("현재 라운드: ", round+1)
                        chkBool = True
                        break
                #(색출루프 빠져나오기)안에서 한 번 발견했으면 다음라운드 가야함
                if(chkBool):
                    break
            #다음 라운드 가기
            if(chkBool):
                continue
            else:
                print("최종라운드 :",round+1)
                return round+1
                    
        
        
        
    # return answer
solution(4,[3, 6, 7, 2, 1, 10, 5, 9, 8, 12, 11, 4])

이게 아니라
내가 지금 바로 낼 수 있는 카드가 있는지 확인 후 지금 집는 카드가 몇턴 후에 (코인까지 계산해서)낼 수 있는지 계산하고 나서 집어야하네

일단 1 순위는 코인 계산
    2 순위가 낼 수 있는 짝이 얼마인지 계산 ==> 몇 턴을 내가 버틸 수 있는지
    3 순위 : 지금 짝이 없지만 몇턴후에 먹으면 낼 수 있는 카드계산