<!doctype html>
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Tetris with jQuery</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		var JQ = $.noConflict();
		var lxUserName = "<?php echo $_GET['user']; ?>";
    </script>
    <script type="text/javascript" src="src/tquery.js"></script>
    <script type="text/javascript" src="src/tetris.js"></script>
    <script type="text/javascript" src="src/script.js"></script>
    <link rel="stylesheet" type="text/css" href="src/tetris.css" />
    <link rel="stylesheet" type="text/css" href="src/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>

<body>

    <div id="pageCover">

        <div id="logo"><img src="src/images/worldpay-logo.png" width="404" height="105" alt="" /></div>
        <!--logo-->

        <div id="contentCover">

            <div id="welcome">
                <h1>It is time to test your knowledge...</h1>
                <a href="javascript:fnShowUsername()">Play the game</a>
            </div>
            <!--welcome-->

            <div id="userDetails">
                <form name="frmUser" id="frmUser">
                    <input type="text" id="txtUser" name="txtUser" value="<?php echo $_GET['user']; ?>" placeholder="username" />
                    <div><a href="javascript:fnShowTetris()">Start Now</a></div>
                    <input type="hidden" id="hdnTime" name="hdnTime" />
                </form>
            </div>
            <!--userDetails-->

            <div id="tetris">
                <div id="tetrisMessage">
                    <img src="src/images/close_btn.png" width="32" height="32" alt="" class="btnClose" />
                    <div class="msg"></div>
                </div>
                <!--tetrisMessage-->

                <div id="timer">00:02:38</div>
                <!--timer-->

                <div id="gridCover">
                    <div id="grid">
                        <table>
                            <tr>
                                <td id="a1"></td>
                                <td id="a2"></td>
                                <td id="a3"></td>
                                <td id="a4"></td>
                                <td id="a5"></td>
                                <td id="a6"></td>
                                <td id="a7"></td>
                                <td id="a8"></td>
                                <td id="a9"></td>
                                <td id="a10"></td>
                            </tr>
                            <tr>
                                <td id="b1"></td>
                                <td id="b2"></td>
                                <td id="b3"></td>
                                <td id="b4"></td>
                                <td id="b5"></td>
                                <td id="b6"></td>
                                <td id="b7"></td>
                                <td id="b8"></td>
                                <td id="b9"></td>
                                <td id="b10"></td>
                            </tr>
                            <tr>
                                <td id="c1"></td>
                                <td id="c2"></td>
                                <td id="c3"></td>
                                <td id="c4"></td>
                                <td id="c5"></td>
                                <td id="c6"></td>
                                <td id="c7"></td>
                                <td id="c8"></td>
                                <td id="c9"></td>
                                <td id="c10"></td>
                            </tr>
                            <tr>
                                <td id="d1"></td>
                                <td id="d2"></td>
                                <td id="d3"></td>
                                <td id="d4"></td>
                                <td id="d5"></td>
                                <td id="d6"></td>
                                <td id="d7"></td>
                                <td id="d8"></td>
                                <td id="d9"></td>
                                <td id="d10"></td>
                            </tr>
                            <tr>
                                <td id="e1"></td>
                                <td id="e2"></td>
                                <td id="e3"></td>
                                <td id="e4"></td>
                                <td id="e5"></td>
                                <td id="e6"></td>
                                <td id="e7"></td>
                                <td id="e8"></td>
                                <td id="e9"></td>
                                <td id="e10"></td>
                            </tr>
                            <tr>
                                <td id="f1"></td>
                                <td id="f2"></td>
                                <td id="f3"></td>
                                <td id="f4"></td>
                                <td id="f5"></td>
                                <td id="f6"></td>
                                <td id="f7"></td>
                                <td id="f8"></td>
                                <td id="f9"></td>
                                <td id="f10"></td>
                            </tr>
                            <tr>
                                <td id="g1"></td>
                                <td id="g2"></td>
                                <td id="g3"></td>
                                <td id="g4"></td>
                                <td id="g5"></td>
                                <td id="g6"></td>
                                <td id="g7"></td>
                                <td id="g8"></td>
                                <td id="g9"></td>
                                <td id="g10"></td>
                            </tr>
                            <tr>
                                <td id="h1"></td>
                                <td id="h2"></td>
                                <td id="h3"></td>
                                <td id="h4"></td>
                                <td id="h5"></td>
                                <td id="h6"></td>
                                <td id="h7"></td>
                                <td id="h8"></td>
                                <td id="h9"></td>
                                <td id="h10"></td>
                            </tr>
                            <tr>
                                <td id="i1"></td>
                                <td id="i2"></td>
                                <td id="i3"></td>
                                <td id="i4"></td>
                                <td id="i5"></td>
                                <td id="i6"></td>
                                <td id="i7"></td>
                                <td id="i8"></td>
                                <td id="i9"></td>
                                <td id="i10"></td>
                            </tr>
                            <tr>
                                <td id="j1"></td>
                                <td id="j2"></td>
                                <td id="j3"></td>
                                <td id="j4"></td>
                                <td id="j5"></td>
                                <td id="j6"></td>
                                <td id="j7"></td>
                                <td id="j8"></td>
                                <td id="j9"></td>
                                <td id="j10"></td>
                            </tr>
                            <tr>
                                <td id="k1"></td>
                                <td id="k2"></td>
                                <td id="k3"></td>
                                <td id="k4"></td>
                                <td id="k5"></td>
                                <td id="k6"></td>
                                <td id="k7"></td>
                                <td id="k8"></td>
                                <td id="k9"></td>
                                <td id="k10"></td>
                            </tr>
                            <tr>
                                <td id="l1"></td>
                                <td id="l2"></td>
                                <td id="l3"></td>
                                <td id="l4"></td>
                                <td id="l5"></td>
                                <td id="l6"></td>
                                <td id="l7"></td>
                                <td id="l8"></td>
                                <td id="l9"></td>
                                <td id="l10"></td>
                            </tr>

                            <tr>
                                <td id="m1"></td>
                                <td id="m2"></td>
                                <td id="m3"></td>
                                <td id="m4"></td>
                                <td id="m5"></td>
                                <td id="m6"></td>
                                <td id="m7"></td>
                                <td id="m8"></td>
                                <td id="m9"></td>
                                <td id="m10"></td>
                            </tr>
                            <tr>
                                <td id="n1"></td>
                                <td id="n2"></td>
                                <td id="n3"></td>
                                <td id="n4"></td>
                                <td id="n5"></td>
                                <td id="n6"></td>
                                <td id="n7"></td>
                                <td id="n8"></td>
                                <td id="n9"></td>
                                <td id="n10"></td>
                            </tr>
                            <tr>
                                <td id="o1"></td>
                                <td id="o2"></td>
                                <td id="o3"></td>
                                <td id="o4"></td>
                                <td id="o5"></td>
                                <td id="o6"></td>
                                <td id="o7"></td>
                                <td id="o8"></td>
                                <td id="o9"></td>
                                <td id="o10"></td>
                            </tr>
                            <tr>
                                <td id="p1"></td>
                                <td id="p2"></td>
                                <td id="p3"></td>
                                <td id="p4"></td>
                                <td id="p5"></td>
                                <td id="p6"></td>
                                <td id="p7"></td>
                                <td id="p8"></td>
                                <td id="p9"></td>
                                <td id="p10"></td>
                            </tr>
                            <tr>
                                <td id="q1"></td>
                                <td id="q2"></td>
                                <td id="q3"></td>
                                <td id="q4"></td>
                                <td id="q5"></td>
                                <td id="q6"></td>
                                <td id="q7"></td>
                                <td id="q8"></td>
                                <td id="q9"></td>
                                <td id="q10"></td>
                            </tr>
                            <tr>
                                <td id="r1"></td>
                                <td id="r2"></td>
                                <td id="r3"></td>
                                <td id="r4"></td>
                                <td id="r5"></td>
                                <td id="r6"></td>
                                <td id="r7"></td>
                                <td id="r8"></td>
                                <td id="r9"></td>
                                <td id="r10"></td>
                            </tr>
                        </table>
                    </div>
                    <!--grid-->

                    <div id="colonnadx">
                        <div id="next">
                            Next:<br/><br/>
                            <table align="center">
                                <tr>
                                    <td id="x00"></td>
                                    <td id="x10"></td>
                                    <td id="x20"></td>
                                    <td id="x30"></td>
                                </tr>
                                <tr>
                                    <td id="x01"></td>
                                    <td id="x11"></td>
                                    <td id="x21"></td>
                                    <td id="x31"></td>
                                </tr>
                                <tr>
                                    <td id="x02"></td>
                                    <td id="x12"></td>
                                    <td id="x22"></td>
                                    <td id="x32"></td>
                                </tr>
                                <tr>
                                    <td id="x03"></td>
                                    <td id="x13"></td>
                                    <td id="x23"></td>
                                    <td id="x33"></td>
                                </tr>
                            </table>
                        </div>
                        <!--next-->
                        <br/><br/>
                        <div id="stats">
                            <div>Row <br/><span id="lines">0</span></div>
                            <div>Level <br/><span id="level">1</span></div>
                            <div>Point <br/><span id="score">0</span></div>
                        </div>
                        <!--stats-->
                        <br/><br/>
                        <!-- <div id="info">
                        <div><strong>left</strong>: J</div>
                        <div><strong>right</strong>: L</div>
                        <div><strong>rotate</strong>: I</div>
                        <div><strong>down</strong>: K</div>
                    </div>
                    <div id="cmd">
                        <input id="start" type="button" value="start" class="button01"/><br/>
                        <input id="stop" type="button" value="stop" class="button02" disabled="disabled"/>
                    </div>cmd -->
                    </div>
                    <!--colonnadx-->

                </div>
                <!--gridCover-->

                <div id="touchControls">
                    <img class="ctrls left" src="./src/images/arrow-left.png" />
                    <img class="ctrls up" src="./src/images/arrow-top.png" />
                    <img class="ctrls right" src="./src/images/arrow-right.png" />
                    <img class="ctrls down" src="./src/images/arrow-bottom.png" />
                </div>
                <!--touchControls-->

            </div>
            <!--tetris-->

            <div id="leaderBoard">
				<div>
					<h1>Leader board</h1>      
					<div id="leaderBoardCntntWrap">         
						<div class="content">loading...</div>             
					</div>
                    <div class="restart">
                        <a href="javascript:fnRestartFresh()">Play Again</a>
                    </div>
				</div>	
            </div><!--leaderBoard-->

        </div>
        <!--contentCover-->

    </div>
    <!--pageCover-->

</body>

</html>
