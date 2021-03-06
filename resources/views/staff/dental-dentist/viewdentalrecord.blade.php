@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<div class="personal-information">
				<div class="row page-header">
					<div class="col-md-4 col-sm-4 col-xs-4">
						<h4>Name</h4>
						<div>{{ $patient_info->patient_first_name }} {{ $patient_info->patient_last_name }}</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<h4>Time</h4>
						<div>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $patient_info->schedule_start)->format('H:i:s') }} - {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $patient_info->schedule_end)->format('H:i:s') }}</div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<h4>Reasons</h4>
						<div>{{ $patient_info->reasons }}</div>
					</div>
				</div>
			</div>  
			<ul class="nav nav-pills nav-justified">
				<li class="active"><a data-toggle="pill" href="#dentalchart">Dental Chart</a></li>
				<li><a data-toggle="pill" href="#additionalrecord">Additional Dental Record</a></li>
				<li><a data-toggle="pill" href="#dentalprescription">Prescription</a></li>
			</ul>
			<div class="tab-content">
				<div class="row table-responsive tab-pane fade in active" id="dentalchart">
					<div class="col-md-9 col-sm-12 col-xs-12">
						<svg id="frame_svg" viewBox="0 0 867 545" >
							<polygon class="dental_chart" id="operation_55" operation_id="{{ $stacks_operation[0] }}" points="234,78,244,74,256,75,262,76,267,79,269,84,271,92,271,102,271,108,266,113,260,113,256,112,253,110,246,112,237,111,233,105,230,97,230,89,232,82,233,79" style="fill:{{ $stacks_operation_color[0] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_55" condition_id="{{ $stacks_condition[0] }}" points="234,78,244,74,256,75,262,76,267,79,267,69,268,62,270,55,273,48,275,41,274,33,273,26,270,24,268,26,267,33,267,40,266,44,261,51,257,56, 255, 59, 254, 64,250,71,245,64,240,57,238,47,236,39,234,29,232,24,229,23,227,26,227,36,229,46,231,54,234,62,235,69,234,77" style="fill:{{ $stacks_condition_color[0] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_54" operation_id="{{ $stacks_operation[1] }}" points="285,73,291,70,298,70,303,71,310,73,315,76,316,81,319,88,319,97,315,104,308,107,302,105,298,103,292,103,285,99,281,94,281,87,281,79,283,75" style="fill:{{ $stacks_operation_color[1] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_54" condition_id="{{ $stacks_condition[1] }}" points="285,73,291,70,298,70,303,71,310,73,315,76,316,68,319,60,321,51,321,43, 321,35,318,30,315,33,312,41,308,54,304,61,299,66,296,63,293,57,290,50,290,40,289,35,285,30,282,34,282,41,284,46,285,55,285,65,285,70" style="fill:{{ $stacks_condition_color[1] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_53" operation_id="{{ $stacks_operation[2] }}" points="332,72,337,68,343,68,349,69,355,73,356,84,356,93,351,99,346,102,340,102,334,99,331,95,332,84,331,76,331,74" style="fill:{{ $stacks_operation_color[2] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_53" condition_id="{{ $stacks_condition[2] }}" points="332,72,337,68,343,68,349,69,355,73,354,65,353,55,353,44,352,33,351,23, 347,15,343,17,342,25,340,30,338,36,336,45,336,56,334,63,333,67" style="fill:{{ $stacks_condition_color[2] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_52" operation_id="{{ $stacks_operation[3] }}" points="371,72,375,69,380,69,385,71,386,77,388,85,390,93,389,100,386,104,379,105,372,103,369,99,367,93,369,84,370,77,370,73" style="fill:{{ $stacks_operation_color[3] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_52" condition_id="{{ $stacks_condition[3] }}" points="371,72,375,69,380,69,385,71,385,65,385,56,385,51,383,43,381,36,379,27,377,22,373,19,371,20,371,26,372,33,373,41,373,51,373,61,371,68" style="fill:{{ $stacks_condition_color[3] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_51" operation_id="{{ $stacks_operation[4] }}" points="410,70,418,69,422,68,426,72,428,75,431,76,433,79,434,88,435,96,434,104,428,110,422,110,414,107,409,105,406,102,406,94,406,85,408,78,410,72" style="fill:{{ $stacks_operation_color[4] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_51" condition_id="{{ $stacks_condition[4] }}" points="410,70,418,69,422,68,426,72,428,75,431,76,433,79,431,70,431,62,431,55,429,45,428,37,427,29,426,24,423,20,420,16,417,22,415,27,413,34,412,38,412,46,412,58,411,65,411,67" style="fill:{{ $stacks_condition_color[4] }};stroke:black;stroke-width:3" />
							
							<polygon class="dental_chart" id="operation_61" operation_id="{{ $stacks_operation[5] }}" points="444,75,450,71,456,70,463,71,467,78,468,87,469,99,463,106,451,109,441,103,440,90,442,80" style="fill:{{ $stacks_operation_color[5] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_61" condition_id="{{ $stacks_condition[5] }}" points="444,75,450,71,456,70,463,71,463,60,462,45,463,33,458,23,452,17,450,26,446,40,445,50,444,64,443,74" style="fill:{{ $stacks_condition_color[5] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_62" operation_id="{{ $stacks_operation[6] }}" points="487,83,489,75,490,71,494,70,497,69,500,71,504,73,504,79,507,89,508,95,505,101,500,105,494,105,487,103,484,97,486,91" style="fill:{{ $stacks_operation_color[6] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_62" condition_id="{{ $stacks_condition[6] }}" points="492,45,494,37,496,28,496,26,500,20,503,18,505,21,504,27,502,34,501,47,502,60,504,72,502,72,498,69,494,70,489,73,489,72,489,71" style="fill:{{ $stacks_condition_color[6] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_63" operation_id="{{ $stacks_operation[7] }}" points="519,76,522,72,526,68,534,68,539,70,542,73,544,76,544,87,544,94,541,100,535,103,529,103,523,98,519,93,517,86,517,86" style="fill:{{ $stacks_operation_color[7] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_63" condition_id="{{ $stacks_condition[7] }}" points="524,27,525,19,529,15,531,17,533,19,533,27,536,33,538,43,540,56,541,66,544,74,539,71,535,68,528,67,522,70,519,73,520,63" style="fill:{{ $stacks_condition_color[7] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_64" operation_id="{{ $stacks_operation[8] }}" points="559,76,565,73,575,70,583,70,588,73,592,77,594,86,594,95,590,101,584,104,578,104,572,107,564,107,558,103,555,97,556,89" style="fill:{{ $stacks_operation_color[8] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_64" condition_id="{{ $stacks_condition[8] }}" points="554,45,553,40,555,33,556,30,559,32,562,39,566,50,570,61,574,66,579,66,583,56,585,47,586,36,588,30,591,30,594,36,592,45,591,48,590,59,590,67,590,75,586,71,580,69,572,70,559,75,559,69,556,61,554,52" style="fill:{{ $stacks_condition_color[8] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_65" operation_id="{{ $stacks_operation[9] }}" points="608,79,616,74,623,74,631,74,640,78,643,85,645,93,644,103,640,108,636,111,629,112,623,110,616,113,609,113,604,108,603,101,604,91" style="fill:{{ $stacks_operation_color[9] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_65" condition_id="{{ $stacks_condition[9] }}" points="607,61,605,54,602,46,601,40,602,30,602,26,605,24,608,27,608,40,615,52,620,60,625,70,633,61,638,50,638,41,641,32,642,24,646,23,649,27,647,41,645,52,640,64,640,74,640,78,630,74,616,74,607,79,608,69" style="fill:{{ $stacks_condition_color[9] }};stroke:black;stroke-width:3" />
							
							<polygon class="dental_chart" id="operation_18" operation_id="{{ $stacks_operation[10] }}" points="100,233,105,231,113,231,118,232,126,236,130,238,133,245,133,253,131,258,125,262,121,265,116,266,113,264,112,263,107,266,101,267,95,264,93,258,93,250,95,243" style="fill:{{ $stacks_operation_color[10] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_18" condition_id="{{ $stacks_condition[10] }}" points="98,205,98,198,97,192,95,185,95,179,95,177,98,177,102,182,103,184,103,177,105,175,108,177,113,187,119,209,125,221,129,232,130,238,124,235,117,231,106,231,100,233,101,231,100,221,99,209" style="fill:{{ $stacks_condition_color[10] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_17" operation_id="{{ $stacks_operation[11] }}" points="144,230,148,227,154,224,166,225,174,226,180,230,185,239,186,252,183,258,177,261,170,261,163,258,159,261,153,262,149,261,143,256,140,248,139,241,140,235" style="fill:{{ $stacks_operation_color[11] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_17" condition_id="{{ $stacks_condition[11] }}" points="145,201,144,195,143,188,144,181,145,178,148,176,151,177,153,184,157,194,160,203,165,208,169,204,168,195,167,188,165,182,165,177,168,178,174,186,178,194,181,209,181,218,180,230,173,225,155,224,148,226,143,231,145,221,147,214,147,205,145,201" style="fill:{{ $stacks_condition_color[11] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_16" operation_id="{{ $stacks_operation[12] }}" points="199,226,208,223,218,221,224,220,230,223,235,227,241,236,241,247,240,255,234,260,228,261,221,259,216,255,211,261,202,261,196,254,193,245,195,234" style="fill:{{ $stacks_operation_color[12] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_16" condition_id="{{ $stacks_condition[12] }}" points="198,176,198,170,200,165,202,163,206,164,210,171,213,181,217,190,223,193,228,190,230,184,229,176,228,171,229,164,231,160,234,162,238,173,239,185,238,197,237,207,237,219,240,229,239,232,233,225,225,220,216,220,207,223,199,226,200,218,203,209,201,192" style="fill:{{ $stacks_condition_color[12] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_15" operation_id="{{ $stacks_operation[13] }}" points="254,226,259,222,266,221,273,224,278,232,280,237,279,247,275,254,273,252,267,259,260,260,252,257,248,248,248,240,251,230" style="fill:{{ $stacks_operation_color[13] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_15" condition_id="{{ $stacks_condition[13] }}" points="257,184,257,175,256,164,254,155,257,145,258,145,264,152,270,173,271,186,271,197,275,212,278,224,277,230,273,224,267,221,260,222,253,227,254,219,256,210" style="fill:{{ $stacks_condition_color[13] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_14" operation_id="{{ $stacks_operation[14] }}" points="293,226,295,222,299,217,306,216,310,219,316,227,319,238,318,248,315,255,309,263,301,264,296,261,295,255,290,250,287,247,288,241,290,232" style="fill:{{ $stacks_operation_color[14] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_14" condition_id="{{ $stacks_condition[14] }}" points="298,184,297,172,299,165,300,156,301,151,303,151,306,160,308,175,311,194,313,212,314,224,311,219,306,216,299,217,294,223,292,226,293,214,295,200" style="fill:{{ $stacks_condition_color[14] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_13" operation_id="{{ $stacks_operation[15] }}" points="329,233,331,225,334,217,337,212,343,211,352,215,360,227,363,239,361,249,356,259,350,264,342,264,333,259,329,249,328,242" style="fill:{{ $stacks_operation_color[15] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_13" condition_id="{{ $stacks_condition[15] }}" points="337,131,341,134,346,144,349,157,351,177,351,193,355,206,357,217,356,220,352,214,343,211,337,212,333,219,334,208,336,196,338,177,339,158,336,138,335,132" style="fill:{{ $stacks_condition_color[15] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_12" operation_id="{{ $stacks_operation[16] }}" points="369,217,375,215,380,215,385,216,388,227,390,239,391,245,392,257,390,262,386,264,380,263,372,260,367,257,364,248,365,236,366,228,367,222" style="fill:{{ $stacks_operation_color[16] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_12" condition_id="{{ $stacks_condition[16] }}" points="373,148,377,150,379,158,382,173,383,195,385,217,379,215,375,215,369,218,370,204,369,186,370,167,370,153" style="fill:{{ $stacks_condition_color[16] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_11" operation_id="{{ $stacks_operation[17] }}" points="403,215,410,210,416,208,421,210,427,218,432,228,434,240,434,250,434,262,428,264,418,264,404,264,397,261,395,257,397,241,398,227,399,220" style="fill:{{ $stacks_operation_color[17] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_11" condition_id="{{ $stacks_condition[17] }}" points="410,143,415,146,419,160,425,179,427,194,429,216,427,219,423,212,416,208,411,210,403,215,401,218,403,208,404,185,406,167,409,151,409,144" style="fill:{{ $stacks_condition_color[17] }};stroke:black;stroke-width:3" />
						
							<polygon class="dental_chart" id="operation_21" operation_id="{{ $stacks_operation[18] }}" points="447,220,452,212,457,208,463,209,469,212,474,218,478,233,479,246,479,256,478,262,469,265,457,264,447,264,442,262,441,255,441,251,440,244,440,236,441,230,445,222" style="fill:{{ $stacks_operation_color[18] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_21" condition_id="{{ $stacks_condition[18] }}" points="450,175,454,166,457,154,461,146,464,142,467,144,467,156,469,175,472,197,473,209,473,217,468,212,463,208,457,208,452,212,447,220,446,209,447,198" style="fill:{{ $stacks_condition_color[18] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_22" operation_id="{{ $stacks_operation[19] }}" points="488,227,489,221,490,217,495,214,499,214,506,218,509,224,511,235,511,247,510,255,506,260,498,262,491,264,486,262,484,260,483,251,484,242" style="fill:{{ $stacks_operation_color[19] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_22" condition_id="{{ $stacks_condition[19] }}" points="493,170,495,161,498,153,501,148,504,150,505,157,506,176,506,186,505,201,506,213,506,218,499,214,495,214,489,217,491,212,491,198" style="fill:{{ $stacks_condition_color[19] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_23" operation_id="{{ $stacks_operation[20] }}" points="518,222,524,214,530,210,537,212,542,216,545,227,548,238,546,249,541,258,537,262,528,265,521,261,517,255,514,246,513,238,514,230" style="fill:{{ $stacks_operation_color[20] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_23" condition_id="{{ $stacks_condition[20] }}" points="524,174,526,160,527,149,532,137,538,130,541,133,538,143,537,166,538,190,540,207,542,216,537,211,530,210,524,214,518,221,517,223,518,213,521,198,523,189,525,178" style="fill:{{ $stacks_condition_color[20] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_24" operation_id="{{ $stacks_operation[21] }}" points="563,221,566,217,572,216,576,218,581,224,585,236,587,245,587,250,582,253,580,257,576,263,570,264,563,261,558,250,556,239,558,230,561,223" style="fill:{{ $stacks_operation_color[21] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_24" condition_id="{{ $stacks_condition[21] }}" points="566,181,567,171,569,160,572,153,574,152,575,156,576,166,578,172,578,183,579,194,582,218,581,224,576,218,572,215,566,217,560,223,561,210,563,197,565,185" style="fill:{{ $stacks_condition_color[21] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_25" operation_id="{{ $stacks_operation[22] }}" points="599,229,603,222,608,221,616,222,624,230,627,246,624,254,618,260,609,259,603,254,602,252,599,253,596,247,595,236,597,229" style="fill:{{ $stacks_operation_color[22] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_25" condition_id="{{ $stacks_condition[22] }}" points="605,182,606,168,610,156,614,146,617,145,619,149,621,154,618,170,618,190,617,210,621,226,619,225,615,222,608,220,603,222,599,229,598,225,600,211,602,202,604,191" style="fill:{{ $stacks_condition_color[22] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_26" operation_id="{{ $stacks_operation[23] }}" points="637,228,646,221,654,219,663,222,669,223,675,226,680,234,681,244,680,253,676,259,670,262,663,261,657,257,652,259,648,261,642,260,635,256,633,249,633,239,635,234" style="fill:{{ $stacks_operation_color[23] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_26" condition_id="{{ $stacks_condition[23] }}" points="637,189,637,179,638,169,642,161,646,161,647,164,648,171,646,183,648,190,653,193,659,190,663,179,666,168,671,164,674,164,677,171,676,182,672,197,673,210,676,223,677,229,674,226,663,221,654,219,646,221,637,228,636,220,639,212,637,200" style="fill:{{ $stacks_condition_color[23] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_27" operation_id="{{ $stacks_operation[24] }}" points="695,229,705,224,716,224,726,226,733,232,736,240,735,250,731,257,727,262,722,262,717,261,712,257,708,261,702,262,696,261,690,256,689,249,690,239,692,235" style="fill:{{ $stacks_operation_color[24] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_27" condition_id="{{ $stacks_condition[24] }}" points="695,202,698,194,702,185,707,179,711,179,710,183,707,192,707,203,709,208,714,204,718,196,722,182,724,178,728,176,731,180,732,192,730,201,728,215,731,227,733,231,725,225,716,224,705,224,695,229,694,224,694,213" style="fill:{{ $stacks_condition_color[24] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_28" operation_id="{{ $stacks_operation[25] }}" points="745,238,752,233,761,230,769,231,777,235,780,243,784,255,782,264,776,267,768,267,763,263,757,267,751,263,744,258,742,249,743,243" style="fill:{{ $stacks_operation_color[25] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_28" condition_id="{{ $stacks_condition[25] }}" points="755,209,760,196,763,183,768,176,773,175,774,179,779,175,782,176,780,189,777,208,775,223,777,235,770,231,760,230,753,233,744,239,746,231,751,220" style="fill:{{ $stacks_condition_color[25] }};stroke:black;stroke-width:3" />
							
							<polygon class="dental_chart" id="condition_48" condition_id="{{ $stacks_condition[26] }}" points="100,335,91,330,86,325,84,315,86,306,90,299,97,296,105,299,111,304,117,299,126,298,131,306,132,313,132,322,128,330,120,335,111,338,104,337" style="fill:{{ $stacks_condition_color[26] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_48" operation_id="{{ $stacks_operation[26] }}" points="89,349,88,358,84,369,82,379,80,385,83,390,88,388,94,379,93,388,96,391,101,390,108,382,117,361,123,342,128,330,119,335,109,338,100,336,91,330,88,327,89,334,90,342" style="fill:{{ $stacks_operation_color[26] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_47" condition_id="{{ $stacks_condition[27] }}" points="135,304,142,298,149,296,157,298,161,304,167,297,172,296,179,299,184,307,186,317,183,329,176,336,167,338,158,336,151,334,142,334,136,329,133,318,134,311" style="fill:{{ $stacks_condition_color[27] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_47" operation_id="{{ $stacks_operation[27] }}" points="137,352,137,359,135,370,134,379,134,394,136,401,139,403,143,400,144,388,148,376,152,363,158,355,160,357,161,366,158,382,157,392,159,401,161,401,166,394,171,381,177,366,180,351,180,343,179,337,178,335,176,336,165,339,152,335,143,334,136,329,137,337" style="fill:{{ $stacks_operation_color[27] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_46" condition_id="{{ $stacks_condition[28] }}" points="199,297,208,298,216,302,219,298,228,297,234,299,242,308,242,316,240,324,238,332,234,336,227,338,216,337,208,337,199,334,194,330,190,321,187,313,188,306,191,300" style="fill:{{ $stacks_condition_color[28] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_46" operation_id="{{ $stacks_operation[28] }}" points="193,353,191,360,186,372,183,379,182,388,182,399,185,406,187,405,190,398,195,384,198,377,207,367,210,358,213,356,217,360,222,371,222,391,221,408,223,409,230,401,236,382,237,369,238,348,236,335,234,336,228,338,208,337,199,334,194,330,194,337" style="fill:{{ $stacks_operation_color[28] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_45" condition_id="{{ $stacks_condition[29] }}" points="262,331,257,332,251,326,247,315,245,308,249,298,257,293,265,292,271,298,278,303,278,314,276,322,273,328,271,330" style="fill:{{ $stacks_condition_color[29] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_45" operation_id="{{ $stacks_operation[29] }}" points="251,332,253,347,253,367,253,381,255,396,259,407,267,397,270,380,272,361,275,334,274,326,271,331,261,332,259,332,253,329,251,326" style="fill:{{ $stacks_operation_color[29] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_44" condition_id="{{ $stacks_condition[30] }}" points="286,323,284,313,283,306,287,297,289,295,291,297,299,293,304,293,311,299,316,299,319,302,319,310,315,322,314,331,311,337,305,339,297,339,290,336,288,331" style="fill:{{ $stacks_condition_color[30] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_44" operation_id="{{ $stacks_operation[30] }}" points="292,359,290,344,288,334,288,332,290,336,297,339,305,339,311,337,313,334,313,344,309,360,309,370,305,389,303,399,300,403,297,403,294,396,293,385" style="fill:{{ $stacks_operation_color[30] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_43" condition_id="{{ $stacks_condition[31] }}" points="327,310,332,300,339,294,346,291,354,297,360,305,361,313,358,327,356,340,355,346,351,352,343,355,337,353,332,347,329,345,326,332,325,322" style="fill:{{ $stacks_condition_color[31] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_43" operation_id="{{ $stacks_operation[31] }}" points="328,363,330,380,331,396,329,411,329,421,333,427,339,422,346,409,350,390,352,374,355,357,355,347,350,352,343,355,337,353,328,344,328,348" style="fill:{{ $stacks_operation_color[31] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_42" condition_id="{{ $stacks_condition[32] }}" points="363,294,370,291,382,291,390,295,393,305,389,318,388,329,387,336,384,339,377,341,373,340,369,337,367,328,364,313,363,306" style="fill:{{ $stacks_condition_color[32] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_42" operation_id="{{ $stacks_operation[32] }}" points="371,368,371,356,371,345,368,337,373,340,379,341,384,339,388,336,385,348,384,363,383,379,382,392,377,403,370,411,366,409,366,405,369,396,371,386" style="fill:{{ $stacks_operation_color[32] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_41" condition_id="{{ $stacks_condition[33] }}" points="405,295,411,294,420,295,427,299,428,306,427,319,424,331,421,336,415,339,412,338,406,333,402,320,401,310,401,301" style="fill:{{ $stacks_condition_color[33] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_41" operation_id="{{ $stacks_operation[33] }}" points="410,363,410,354,409,342,407,334,412,339,415,339,421,337,423,331,423,347,421,369,420,382,417,393,411,403,409,403,407,400,408,390,409,380" style="fill:{{ $stacks_operation_color[33] }};stroke:black;stroke-width:3" />
							
							<polygon class="dental_chart" id="condition_31" condition_id="{{ $stacks_condition[34] }}" points="447,308,448,300,451,296,462,294,469,294,472,298,474,309,473,320,469,332,465,337,461,340,456,339,453,335,451,330" style="fill:{{ $stacks_condition_color[34] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_31" operation_id="{{ $stacks_operation[34] }}" points="452,357,451,343,452,332,454,337,458,339,461,340,466,337,468,334,467,341,465,352,464,363,466,379,467,388,467,395,467,402,465,404,461,401,458,394,456,388" style="fill:{{ $stacks_operation_color[34] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_32" condition_id="{{ $stacks_condition[35] }}" points="483,305,484,296,491,292,503,292,510,293,513,299,511,310,508,328,505,338,501,341,496,342,489,337,488,337" style="fill:{{ $stacks_condition_color[35] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_32" operation_id="{{ $stacks_operation[35] }}" points="491,365,489,350,488,336,496,342,501,340,506,337,504,351,503,370,504,385,506,395,509,405,509,410,505,411,499,406,494,395,493,388" style="fill:{{ $stacks_operation_color[35] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_33" condition_id="{{ $stacks_condition[36] }}" points="517,301,525,293,531,292,536,294,545,303,550,315,550,329,547,338,547,344,543,350,535,354,527,353,523,349,521,346,519,338,517,329,514,317,513,310,513,304" style="fill:{{ $stacks_condition_color[36] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_33" operation_id="{{ $stacks_operation[36] }}" points="524,383,527,401,532,414,539,425,543,426,546,420,545,394,546,361,547,344,543,350,534,355,526,353,520,346,521,354" style="fill:{{ $stacks_operation_color[36] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_34" condition_id="{{ $stacks_condition[37] }}" points="555,309,556,301,558,299,562,299,568,296,571,293,575,292,580,295,584,298,586,295,589,295,592,305,592,315,589,327,586,333,581,337,573,338,567,337,563,336,561,327" style="fill:{{ $stacks_condition_color[37] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_34" operation_id="{{ $stacks_operation[37] }}" points="565,353,563,344,562,337,563,335,568,338,576,338,581,337,587,333,585,341,582,362,582,377,582,388,580,397,578,403,575,403,571,398,569,387" style="fill:{{ $stacks_operation_color[37] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_35" condition_id="{{ $stacks_condition[38] }}" points="598,314,597,304,598,301,604,298,607,294,613,293,621,294,628,302,630,312,627,322,622,329,618,332,612,333,607,331,603,329" style="fill:{{ $stacks_condition_color[38] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_35" operation_id="{{ $stacks_operation[38] }}" points="603,360,601,346,600,331,601,324,602,330,612,333,618,332,622,329,626,323,623,341,621,363,621,382,621,393,617,404,615,405,611,401,608,395,605,385" style="fill:{{ $stacks_operation_color[38] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_36" condition_id="{{ $stacks_condition[39] }}" points="646,337,639,335,635,325,633,314,635,304,643,297,652,297,657,299,660,303,664,299,672,297,682,299,688,303,688,311,686,319,682,329,677,334,668,337,661,336,651,336" style="fill:{{ $stacks_condition_color[39] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_36" operation_id="{{ $stacks_operation[39] }}" points="637,366,638,351,638,334,646,338,657,336,669,337,678,333,682,329,681,346,683,355,689,371,693,387,693,398,692,404,689,406,685,398,679,381,672,372,666,366,663,357,658,361,653,372,652,384,653,397,653,407,651,408,645,402,642,393" style="fill:{{ $stacks_operation_color[39] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_37" condition_id="{{ $stacks_condition[40] }}" points="690,316,690,308,694,301,702,296,707,296,712,301,715,303,720,298,728,296,735,299,739,306,741,314,740,325,738,332,729,334,721,334,712,336,706,338,697,335,692,329,690,325" style="fill:{{ $stacks_condition_color[40] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_37" operation_id="{{ $stacks_operation[40] }}" points="694,350,695,341,697,335,707,338,713,336,724,334,729,335,738,331,738,345,737,357,741,368,742,381,740,394,739,402,736,404,734,403,731,399,729,384,724,366,719,356,715,355,713,360,716,375,717,390,718,399,716,401,713,400,710,396,704,383,698,369" style="fill:{{ $stacks_operation_color[40] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_38" condition_id="{{ $stacks_condition[41] }}" points="751,332,745,329,742,322,741,313,744,305,750,299,756,298,763,303,764,305,769,298,779,295,785,299,790,311,790,322,785,330,778,334,771,337,766,338" style="fill:{{ $stacks_condition_color[41] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_38" operation_id="{{ $stacks_operation[41] }}" points="757,357,754,348,749,335,747,330,766,338,775,336,785,330,788,326,784,338,786,351,789,364,793,376,794,385,793,390,791,391,787,388,780,378,782,388,781,392,774,392,768,382" style="fill:{{ $stacks_operation_color[41] }};stroke:black;stroke-width:3" />
							
							<polygon class="dental_chart" id="condition_85" condition_id="{{ $stacks_condition[42] }}" points="235,463,235,455,239,448,242,446,247,448,249,449,255,445,260,445,264,446,267,449,274,445,279,445,282,447,283,458,281,470,276,476,268,479,258,480,251,480,243,479,238,475,236,472" style="fill:{{ $stacks_condition_color[42] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_85" operation_id="{{ $stacks_operation[42] }}" points="238,495,239,484,239,476,244,479,250,480,267,479,276,476,277,485,278,502,280,513,281,522,281,531,278,531,276,528,269,506,264,494,259,490,256,490,251,496,244,509,240,522,237,531,235,534,232,533,231,530,231,525,232,521" style="fill:{{ $stacks_operation_color[42] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_84" condition_id="{{ $stacks_condition[43] }}" points="302,481,296,479,289,475,286,466,286,455,287,450,292,446,299,448,304,452,311,449,318,448,323,456,326,465,325,474,322,481,316,482,308,480,306,480" style="fill:{{ $stacks_condition_color[43] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_84" operation_id="{{ $stacks_operation[43] }}" points="286,488,290,480,292,477,296,480,302,481,306,480,315,481,321,481,322,481,326,485,327,496,329,509,328,519,324,527,321,529,319,528,317,513,315,499,309,489,304,489,298,493,295,502,294,515,293,524,291,527,288,525,286,515,284,507,284,501" style="fill:{{ $stacks_operation_color[43] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_83" condition_id="{{ $stacks_condition[44] }}" points="342,482,337,481,332,475,332,465,333,455,337,449,343,445,347,444,353,451,357,459,358,471,355,481,348,481" style="fill:{{ $stacks_condition_color[44] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_83" operation_id="{{ $stacks_operation[44] }}" points="335,506,334,498,332,488,333,482,335,478,338,481,343,482,355,481,352,491,349,505,348,517,347,527,344,535,341,539,340,538,337,532,336,524" style="fill:{{ $stacks_operation_color[44] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_82" condition_id="{{ $stacks_condition[45] }}" points="379,478,373,478,368,473,367,465,366,454,368,449,376,444,382,443,386,447,388,460,387,473,384,478,381,478" style="fill:{{ $stacks_condition_color[45] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_82" operation_id="{{ $stacks_operation[45] }}" points="370,494,369,487,370,477,370,475,373,478,384,479,384,487,381,508,381,518,380,525,377,529,376,527,374,521,372,514" style="fill:{{ $stacks_operation_color[45] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_81" condition_id="{{ $stacks_condition[46] }}" points="414,483,410,481,407,475,407,467,406,457,407,448,414,445,419,447,423,452,423,465,422,477,420,482,417,483" style="fill:{{ $stacks_condition_color[46] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_81" operation_id="{{ $stacks_operation[46] }}" points="408,480,406,487,406,496,407,507,408,515,411,522,413,522,414,518,416,508,417,496,419,488,420,484,420,481,417,483,414,484,410,481" style="fill:{{ $stacks_operation_color[46] }};stroke:black;stroke-width:3" />

							<polygon class="dental_chart" id="condition_71" condition_id="{{ $stacks_condition[47] }}" points="460,483,454,481,452,473,451,461,452,452,455,446,462,446,468,449,469,457,468,470,466,478,464,481" style="fill:{{ $stacks_condition_color[47] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_71" operation_id="{{ $stacks_operation[47] }}" points="455,485,455,482,460,484,462,483,465,480,467,478,469,487,468,499,467,514,464,523,463,522,461,517,459,505" style="fill:{{ $stacks_operation_color[47] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_72" condition_id="{{ $stacks_condition[48] }}" points="497,479,492,478,488,475,487,468,487,459,489,449,492,443,498,443,503,446,508,451,508,455,507,467,506,475,503,478" style="fill:{{ $stacks_condition_color[48] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_72" operation_id="{{ $stacks_operation[48] }}" points="492,493,490,481,489,475,492,479,502,478,506,476,506,491,504,507,502,517,498,528,497,528,495,527,494,520" style="fill:{{ $stacks_operation_color[48] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_73" condition_id="{{ $stacks_condition[49] }}" points="531,482,523,482,520,480,516,472,517,460,522,450,529,444,535,447,540,453,543,463,543,472,541,478,537,481" style="fill:{{ $stacks_condition_color[49] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_73" operation_id="{{ $stacks_operation[49] }}" points="525,502,522,489,520,482,520,480,524,482,532,482,537,481,541,479,542,488,540,503,539,512,539,525,537,535,534,539,532,539,530,536,528,530" style="fill:{{ $stacks_operation_color[49] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_74" condition_id="{{ $stacks_condition[50] }}" points="569,480,560,482,554,482,551,476,550,467,552,455,559,449,564,448,571,454,576,450,581,446,586,448,590,456,590,467,586,476,581,480,572,480" style="fill:{{ $stacks_condition_color[50] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_74" operation_id="{{ $stacks_operation[50] }}" points="547,495,550,486,553,480,556,483,563,483,567,481,574,480,579,480,582,480,587,482,589,496,590,509,588,520,585,526,583,527,581,515,579,502,577,493,570,489,565,490,559,503,557,515,555,529,554,530,548,526,546,515,546,510" style="fill:{{ $stacks_operation_color[50] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="condition_75" condition_id="{{ $stacks_condition[51] }}" points="600,477,595,470,594,460,594,448,596,445,601,445,607,447,609,448,613,445,617,444,623,445,626,448,627,448,632,446,637,446,641,452,640,463,638,475,632,479,623,480,617,480,612,480" style="fill:{{ $stacks_condition_color[51] }};stroke:black;stroke-width:3" />
							<polygon class="dental_chart" id="operation_75" operation_id="{{ $stacks_operation[51] }}" points="597,497,598,487,600,477,612,481,631,479,637,476,636,490,639,502,641,514,644,520,644,531,642,534,639,533,637,527,633,513,625,497,619,490,615,490,609,500,604,513,600,526,598,531,595,532,594,526,594,526" style="fill:{{ $stacks_operation_color[51] }};stroke:black;stroke-width:3" />
						</svg>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12">
					  <h4>Legend</h4>
					  <label>Condition</label>
					  <button type="button" class="btn btn-info btn-block legend-button" id="condition_1">Caries free</button>
					  <button type="button" class="btn btn-info btn-block legend-button" id="condition_2">Caries for filting </button>
					  <button type="button" class="btn btn-info btn-block legend-button" id="condition_3">Caries for extraction</button>
					  <button type="button" class="btn btn-info btn-block legend-button" id="condition_4">Root fragment</button>
					  <button type="button" class="btn btn-info btn-block legend-button" id="condition_5">Missing due to carries </button>
					  <br/>
					  <label>Operation</label>
					  <button type="button" class="btn btn-info btn-block legend-button" id="operation_1">Amalgam filling</button>
					  <button type="button" class="btn btn-info btn-block legend-button" id="operation_2">Silicate filling</button>
					  <button type="button" class="btn btn-info btn-block legend-button" id="operation_3">Extraction due to caries</button>
					  <button type="button" class="btn btn-info btn-block legend-button" id="operation_4">Extraction due to other causes</button>
					  <button type="button" class="btn btn-info btn-block legend-button" id="operation_5">Cement filling</button>
					</div>
			  </div>
			  <br/>
			  <div class="row table-responsive tab-pane fade" id="additionalrecord">
			  	<div class="col-md-8 col-md-offset-2">
			  		<div class="panel-group">
			  			<div class="panel panel-success">
			  				<div class="panel-heading">
			  					<h4>Patient's age: <b>{{ $patient_age }}</b></h4>
			  				</div>
			  				@if(count($additional_dental_records) == 1)
			  				<div class="panel-body" id="additionalDentalRecordPanelBody" style="background-color:#d6e9c6; ">
			  					<div class="row" style="background-color:#f8f8f8; padding:5px">
			  						<div class="col-md-7 col-sm-7 col-xs-12">
			  							<h4>Presence of dental caries</h4>
			  						</div>
			  						<div class="col-md-5 col-sm-5 col-xs-12">
			  							<select class="form-control" id="selDentalCaries" disabled>
			  								@if($additional_dental_records->dental_caries == 'Yes')
			  								<option value="yes" selected>Yes</option>
			  								@else
			  								<option value="no" selected>No</option>
			  								@endif
			  							</select>
			  						</div>
			  					</div>
			  					<div class="row" style="padding:5px">
			  						<div class="col-md-7 col-sm-7 col-xs-12">
			  							<h4>Presence of gingivitis</h4>
			  						</div>
			  						<div class="col-md-5 col-sm-5 col-xs-12">
			  							<select class="form-control" id="selGingivitis" disabled>
												@if($additional_dental_records->gingivitis == 'Yes')
			  								<option value="yes" selected>Yes</option>
			  								@else
			  								<option value="no" selected>No</option>
			  								@endif
											</select>
										</div>
									</div>
									<div class="row" style="background-color:#f8f8f8; padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of peridontal pocket</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selPeridontalPocket" disabled>
												@if($additional_dental_records->peridontal_pocket == 'Yes')
			  								<option value="yes" selected>Yes</option>
			  								@else
			  								<option value="no" selected>No</option>
			  								@endif
											</select>
										</div>
									</div>
									<div class="row" style="padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of oral debris</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selOralDebris" disabled>
												@if($additional_dental_records->oral_debris == 'Yes')
			  								<option value="yes" selected>Yes</option>
			  								@else
			  								<option value="no" selected>No</option>
			  								@endif
											</select>
										</div>
									</div>
									<div class="row" style="background-color:#f8f8f8; padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of calculus</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selCalculus" disabled>
												@if($additional_dental_records->calculus == 'Yes')
			  								<option value="yes" selected>Yes</option>
			  								@else
			  								<option value="no" selected>No</option>
			  								@endif
											</select>
										</div>
									</div>
									<div class="row" style="padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of neoplasm</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selNeoplasm" disabled>
												@if($additional_dental_records->neoplasm == 'Yes')
			  								<option value="yes" selected>Yes</option>
			  								@else
			  								<option value="no" selected>No</option>
			  								@endif
											</select>
										</div>
									</div>
									<div class="row" style="background-color:#f8f8f8; padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of dental-facio anomaly</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selDentalFacioAnomaly" disabled>
												@if($additional_dental_records->dental_facio_anomaly == 'Yes')
			  								<option value="yes" selected>Yes</option>
			  								@else
			  								<option value="no" selected>No</option>
			  								@endif
											</select>
										</div>
									</div>
									<div class="row" style="padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Number of teeth present</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<input type="text" class="form-control" id="teethPresent" value="{{ $additional_dental_records->teeth_present }}" disabled>
										</div>
									</div>
								</div>
			  				@else
			  				<div class="panel-body" id="additionalDentalRecordPanelBody">
			  					<div class="row" style="background-color:#f8f8f8; padding:5px">
			  						<div class="col-md-7 col-sm-7 col-xs-12">
			  							<h4>Presence of dental caries</h4>
			  						</div>
			  						<div class="col-md-5 col-sm-5 col-xs-12">
			  							<select class="form-control" id="selDentalCaries" disabled>
			  								<option disabled selected>--- option ---</option>
			  								<option value="yes">Yes</option>
			  								<option value="no">No</option>
			  							</select>
			  						</div>
			  					</div>
			  					<div class="row" style="padding:5px">
			  						<div class="col-md-7 col-sm-7 col-xs-12">
			  							<h4>Presence of gingivitis</h4>
			  						</div>
			  						<div class="col-md-5 col-sm-5 col-xs-12">
			  							<select class="form-control" id="selGingivitis" disabled>
			  								<option disabled selected>--- option ---</option>
												<option value="yes">Yes</option>
												<option value="no">No</option>
											</select>
										</div>
									</div>
									<div class="row" style="background-color:#f8f8f8; padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of peridontal pocket</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selPeridontalPocket" disabled>
												<option disabled selected>--- option ---</option>
												<option value="yes">Yes</option>
												<option value="no">No</option>
											</select>
										</div>
									</div>
									<div class="row" style="padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of oral debris</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selOralDebris" disabled>
												<option disabled selected>--- option ---</option>
												<option value="yes">Yes</option>
												<option value="no">No</option>
											</select>
										</div>
									</div>
									<div class="row" style="background-color:#f8f8f8; padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of calculus</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selCalculus" disabled>
												<option disabled selected>--- option ---</option>
												<option value="yes">Yes</option>
												<option value="no">No</option>
											</select>
										</div>
									</div>
									<div class="row" style="padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of neoplasm</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selNeoplasm" disabled>
												<option disabled selected>--- option ---</option>
												<option value="yes">Yes</option>
												<option value="no">No</option>
											</select>
										</div>
									</div>
									<div class="row" style="background-color:#f8f8f8; padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of dental-facio anomaly</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selDentalFacioAnomaly" disabled>
												<option disabled selected>--- option ---</option>
												<option value="yes">Yes</option>
												<option value="no">No</option>
											</select>
										</div>
									</div>
									<div class="row" style="padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Number of teeth present</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<input type="text" class="form-control" id="teethPresent" disabled>
										</div>
									</div>
			  				</div>
			  				@endif
						  </div>
						</div>
					</div>
				</div>
				<br>
				<div class="row table-responsive tab-pane fade" id="dentalprescription">
			  	<div class="col-md-8 col-md-offset-2">
			  		<div class="panel panel-primary">
			  			@if(count($patient_info->prescription) > 0)
				      	<div class="panel-body">{{ $patient_info->prescription }}</div>
				      @else
				      	<div class="panel-body">No prescription yet.</div>
				      @endif
				    </div>
			  	</div>
			  </div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade update-dental-record-modal" id="update-dental-record-modal" role="dialog">
  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>
		  <div class="modal-body">
			<div class="add-dental-record">
			  <label>Condition</label>
			  <select class="form-control condition" id="condition">
				<option disabled selected value="0">--options--</option>
				<option value="1">Caries free</option>
				<option value="2">Caries for filting</option>
				<option value="3">Caries for extraction</option>
				<option value="4">Root fragment</option>
				<option value="5">Missing due to carries</option>
			  </select>
			  <br/>
			  <label>Operation</label>
			  <select class="form-control operation" id="operation">
				<option disabled selected value="0">--options--</option>
				<option value="1">Amalgam filling</option>
				<option value="2">Silicate filling</option>
				<option value="3">Extraction due to caries</option>
				<option value="4">Extraction due to other causes</option>
				<option value="5">Cement filling</option>
			  </select>
			</div>
		  </div>
		  <div class="modal-footer">
				<button type="button" class="btn btn-info updateDentalRecord" id="updateDentalRecord_{{ $appointment_id }}">Update</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		  </div>
		</div>
  </div>
</div>

<div class="modal fade confirm_additional_dental_record" id="confirm_additional_dental_record" role="dialog">
  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h5><b>Saving additional dental record</b></h5>
		  </div>
		  <div class="modal-body">
				<h4>Are you sure you want to save this?</h4>
		  </div>
		  <div class="modal-footer">
				<button type="button" class="btn btn-info confirmAdditionalDentalRecord" id="confirmAdditionalDentalRecord_{{ $appointment_id }}">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		  </div>
		</div>
  </div>
</div>

@endsection