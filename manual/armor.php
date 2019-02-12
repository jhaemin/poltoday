<?php
include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>장비 매뉴얼</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" href="css/manual.css?v=1.000">
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/globalnav.php'; ?>

	<main id="armor-main">

		<a href="#"><button class="go-to-top">맨 위로</button></a>

		<h1>장비 대원 매뉴얼</h1>
		<p>이 매뉴얼만 완벽히 숙지한다면 당신은 <b>'장비마스터'</b>가 될 수 있다.</p>

		<div class="table">
			<a href="#everyday"><button>매일 해야하는 일</button></a>
			<a href="#every-week"><button>매주 해야하는 일</button></a>
			<a href="#every-month"><button>매달 해야하는 일</button></a>
			<a href="#every-year"><button>매년 해야하는 일</button></a>
			<a href="#irregular"><button>불규칙적으로 해야하는 일</button></a>
		</div>

		<div class="table">
			<a href="#monthly-report"><button>월보</button></a>
			<a href="#fix-walkie-talkie"><button>무전기 수리</button></a>
			<a href="#confidential"><button>비밀문서</button></a>
			<a href="#gun"><button>사격</button></a>
		</div>

		<section id="everyday">
			<h2>매일 해야하는 일</h2>
			<ul>
				<li>당일 경력이 상황 또는 우발대비인 경우 전투화학 창고에서 장비를 꺼내줘야한다.</li>
				<ul>
					<li><span class="green bold">현재(2018-11-27) 기준: </span> 대형 캡사이신 3개, 중형 캡사이신 각 소대 2개, 소형 캡사이신 각 소대 4개씩</li>
					<li class="warning">꺼내거나 넣을 때 분실하기 쉬운 소/중형 캡사이신 수량 꼭 확인하기!! (특히 창고에 넣을 때)</li>
				</ul>
			</ul>
		</section>

		<section id="every-week">
			<h2>매주 해야하는 일</h2>
			<ul>
				<li>띠용</li>
			</ul>
		</section>

		<section id="every-month">
			<h2>매달 해야하는 일</h2>
			<ul>
				<li id="monthly-report">월보</li>
				<ul>
					<li>다음 달 1일~15일 사이에 전 달 월보를 하면 된다. 예) 9월 월보는 10월 1일부터 10월 15일 사이에 끝내야 한다.</li>
					<li class="warning">주유 카드는 단장님 결재를 받기때문에 반드시 7일 안에 기장계에 제출해야한다.</li>
					<li>중대장님 결재가 끝나면 출력해서 황파일에 철하기.(급하면 직접 결재해서 바로 출력)</li>
					<li class="bold">월보 리스트</li>
					<ul>
						<li class="blue bold">< 매 월 ></li>
						<ul>
							<li class="orange bold">< 정보화 장비 > (묶어서 하나의 공문으로 발송)</li>
							<li>보안진단의 날 바이러스 점검</li>
							<li>정보화 교육 결과보고</li>
							<li>인터넷 pc유해사이트 차단 점검 결과보고</li>
							<li>사이버 보안진단 점검 결과보고</li>
							<li>개인정보보호의 날 점검결과</li>
						</ul>
						<ul>
							<li class="orange bold">< 나머지 > (개별 공문으로 발송)</li>
							<li>경찰장비교육 실시결과</li>
							<li>장비점검결과보고</li>
							<li>무기월보 결과보고</li>
							<li>차량월보</li>
							<li>총기수입 실시보고</li>
							<li>보안진단 결과 보고</li>
						</ul>
						<li class="blue bold">< 분기별 > (3, 6, 9, 12월, 보고는 4, 7, 10, 1월에)</li>
						<ul>
							<li>무기 탄약 보유현황 보고</li>
							<li>경찰장비 안전교육 및 검사 실시 현황</li>
						</ul>
					</ul>
					<li>길안내기점검보고</li>
					<li>영상정보처리기기점검보고</li>
					<li>채증대원교육결과보고</li>
				</ul>

				<li>의약품 대장</li>
				<ul>
					<li>매달 해도 되고 매주 해도 된다.(매일 해도 된다)</li>
					<li>서울청이나 기동본부 복무점검 시 검사할 수 있기때문에 적어도 매달 꼭 업데이트 할 것.</li>
					<li class="orange">황파일은 1년마다 교체</li>
				</ul>

				<li>소화기 사인</li>
				<li>채증대원 업데이트</li>
				<ul>
					<li>채증대원 변경 시 행정반 장비 대원에게 보고하라고 교양</li>
					<li>변경 시 온나라 > 문등대 > 채증담당 > 재작성</li>
					<li>채증반장님께 변경 인원 쪽지 보내기</li>
				</ul>

			</ul>
		</section>

		<section id="every-quarter">
			<h2>분기별로 해야하는 일</h2>
			<ul>
				<li>기본용품 신청 및 의약품 신청</li>
				<ul>
					<li>경무계에서 쪽지가 오면 필요한 수량만큼 금액에 맞춰서 답장하면 된다.</li>
					<li class="warning">창고를 잘 확인해서 정말 필요하고 부족한 물품 위주로 신청하자!</li>
					<li><span class="green bold">35중대 행정 > 장비 > ★기본용품, 의약품 신청</span></li>
				</ul>
				<li>매뉴얼 평가</li>
				<ul>
					<li><span class="green bold">35중대 행정 > 장비 > @매뉴얼평가</span></li>
				</ul>
			</ul>
		</section>

		<section id="every-year">
			<h2>매년 해야하는 일</h2>
			<ul>
				<li id="gun">사격</li>
				<ul>
					<li>사격 준비는 크게 아래의 단계로 나뉜다.</li>
					<ol>
						<li>사전 교육 (최소 2번)</li>
						<li>사전 보고 (사격 인원, 사격 명단)</li>
						<li>사격 준비 (탄약 준비, 표적지 출력, 탄약지급/탄피회수 대장 만들기)</li>
						<li>사격 실시 (장소 및 날짜 확인)</li>
						<li>사격 후 보고 (점수 및 탄약 잔여량)</li>
					</ol>
					<li><span class="green bold">35중대 행정 > 장비 > 사격</span> 폴더에서 자세한 내용 확인</li>
				</ul>
				<li>황파일 만들기</li>
			</ul>
		</section>

		<section id="irregular">
			<h2>불규칙적으로 해야하는 일</h2>
			<ul>
				<li>장비 업무에서 가장 중요한 것은 현황 파악이므로 아래 항목들은 상시 현황을 파악하고 있으면 좋다.</li>
				<ul>
					<li>채증장비</li>
					<li>무선장비</li>
					<li>컴퓨터</li>
					<li>경찰장비</li>
					<li>차량</li>
					<li>운전대원</li>
					<li>형광점퍼 내피(포스), 형광점퍼 외피(고텍) : 수량 변동이 잦고 수량 확인 주기가 긴 편이므로 필요할 때마다 각 소대 인원담당이나 분대장 대원에게 수량 파악을 요청하는 것이 더 정확하다.</li>
				</ul>

				<li id="confidential">비밀문서 접수/파기</li>
				<ul>
					<li>접수 날짜는 매 월로 표기되어있지만 보병연대에서 매우 불규칙적으로 가져온다.<br>즉, 그냥 보병연대에서 비밀문서를 가져올 때 하면 된다.</li>
					<li>파기 날짜 이전에는 비전자문서 파기가 되지 않으니 반드시 파기 날짜 이후에 보안나라에 접속한다.</li>
					<li class="warning bold">2018년 10월 이후로 전자문서로만 접수/파기하며, 다목적실 비밀문서 보관함에 있는 비전자문서는 2019년 12월 31일에 모두 파기한다.</li>
					<li class="bold blue">접수 방법</li>
					<ol>
						<li>보안 USB를 행부관님 컴퓨터에 연결한다.</li>
						<li>VPN Client를 실행하고, 행정소대장 선택, 암호: "8*8"</li>
						<li>보안나라 실행 후 행정소대장님으로 로그인. 암호: 행소1035!</li>
						<li>비밀문서 접수</li>
						<li>모든 날짜는 접수 날짜로 동일하게 설정, 비밀문서 구분은 대외비</li>
					</ol>
					<li class="bold blue">파기 방법</li>
					<ol>
						<li>행소님 파기 신청 -> 중대장님 승인 -> 행소님 파기 실행</li>
						<li>중대장님 암호: 2699@ttyyuu#</li>
					</ol>
				</ul>

				<li id="fix-walkie-talkie">무전기 수리 접수</li>
				<ol>
					<li>행소님 폴넷 로그인</li>
					<li>우측 상단 나의 메뉴에서 서울청 무선장비고장접수</li>
					<li>수리신청</li>
					<li>소속, 제조사 선택</li>
					<li>페이징은 수신기, PCS와 자망은 휴대용</li>
					<li>PCS와 자망은 <span class="bold">ID번호(TRS)</span>에 입력<br>페이징은 <span class="bold">일련번호(VHF)</span>에 입력</li>
					<li>증상 입력</li>
					<li>구분은 항상 <span class="bold">비포서비스접수</span></li>
					<li>수리신청내역서출력</li>
					<li>최근 항목은 가장 아래쪽에 있음. 체크해서 3장 출력</li>
					<li>무전기 배터리는 모두 분리해서 수리신청내역서 3장과 함께 통신반에 제출.</li>
					<li>통신반에서 수리신청내역서 1장 받고 황파일에 철하기</li>
				</ol>
			</ul>
		</section>

	</main>

</body>
</html>