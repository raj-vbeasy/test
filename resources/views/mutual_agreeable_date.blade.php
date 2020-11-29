<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mutual Agreeable Date</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}

        input[type=month],input[type=text], select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
            resize: vertical;
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .w100 {
            width: 100%;
            display: flex;
        }

        .s100 {
            width: 25%;
            margin: 10px;
        }

        .map {
            margin-top: 35px;
            margin-left: 20px;
        }

        @media only screen and (max-width: 720px) {
            .w100 {
                display: block;
            }
            .s100 {
                width: 100%;
            }
            .map {
                margin-top: 0px;
                margin-bottom: 20px;
            }
        }

        h1 {text-align: center;}
        h3 {text-align: center;}

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: grey;
            color: white;
            text-align: center;
        }
        .hide {
            display: none!important;
        }
    </style>
</head>
<body>
<h1>Peak Performances Inc</h1>

<h3>Explore Mutually Agreeable Dates for Future Consideration</h3>

<div class="container">
    <form action="{{ route('mad', ['token' => $token]) }}" method="post">
        @csrf
        <label for="yes_no_radio">Would you love to Explore Mutually Agreeable Dates?</label><br><br>
        <input type="radio" id="yes_no_radio" name="yes_no" value="yes" checked>Yes
        <input type="radio" name="yes_no" value="no">No
        <br>
        <div id="mad-container">
            <h4>Artist Representative - Please enter any of your Mutually Agreeable Date Options</h4>

            <div class="w100">
                <div class="s100">
                    <label for="month"><b> Month:</b></label>
                </div>

                <div class="s100">
                    <label for="days"><b> Day of Week</b></label>
                </div>

                <div class="s100">
                    <label for="year"><b> Year</b></label>
                </div>

                <div class="s100"></div>
            </div>
            @for($i = 0; $i < 5; $i++)
                <div class="w100">
                    <div class="s100">
                        <select name="dates[{{ $i }}][month]" id="month">
                            <option value=""> Choose Month </option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>

                    <div class="s100">
                        <select data-attr="dropdown" name="dates[{{ $i }}][day]" id="days">
                            <option value=""> Select Day of Week </option>
                            <option value="Monday" id="Monday">Monday</option>
                            <option value="Tuesday" id="Tuesday">Tuesday</option>
                            <option value="Wednesday" id="Wednesday">Wednesday</option>
                            <option value="Thursday" id="Thursday">Thursday</option>
                            <option value="Friday" id="Friday">Friday</option>
                            <option value="Saturday" id="Saturday">Saturday</option>
                            <option value="Sunday" id="Sunday">Sunday</option>
                        </select>
                    </div>

                    <div class="s100">
                        <select name="dates[{{ $i }}][year]" id="year">
                            <option value=""> Select Year </option>
                            <option value="2020">2020</option>
                            <option value="2019">2021</option>
                            <option value="2018">2022</option>
                            <option value="2017">2023</option>
                            <option value="2016">2024</option>
                            <option value="2015">2025</option>
                            <option value="2014">2026</option>
                            <option value="2013">2027</option>
                            <option value="2012">2028</option>
                            <option value="2011">2029</option>
                            <option value="2010">2030</option>
                            <option value="2009">2031</option>
                            <option value="2009">2032</option>
                            <option value="2008">2033</option>
                            <option value="2007">2034</option>
                            <option value="2006">2035</option>
                            <option value="2005">2036</option>
                            <option value="2004">2037</option>
                            <option value="2003">2038</option>
                            <option value="2002">2039</option>
                            <option value="2001">2040</option>
                            <option value="2000">2041</option>
                            <option value="1999">2042</option>
                            <option value="1998">2043</option>
                            <option value="1997">2044</option>
                            <option value="1996">2045</option>
                            <option value="1995">2046</option>
                            <option value="1994">2047</option>
                            <option value="1993">2048</option>
                            <option value="1992">2049</option>
                            <option value="1991">2050</option>
                        </select>
                    </div>

                    <div class="s100">
                        <div class="map" >
                            <a href="#">Map</a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <br/>
        <br/>
        <label for="subject">Queries / Suggestions / Notes</label>
        <textarea id="subject" name="notes" placeholder="Let us know your suggestions if any.." style="height:200px">{{ old('notes', '') }}</textarea>
        <input type="submit" value="Submit">
    </form>
</div><br><br><br><br>
<div class="footer">
    <p>© 2020 Peak Performances. All rights reserved | Developed by <a href="https://vbeasy.com" style="color:white;">VB Easy</a></p>
</div>
</body>
<script>
  let prev = null;
  document.getElementsByName('yes_no').forEach(function (item, idx) {
    item.addEventListener('change', function() {
      if (this !== prev) {
        prev = this;
      }
      if (this.value === 'no') {
        document.getElementById('mad-container').classList.add('hide');
      } else {
        document.getElementById('mad-container').classList.remove('hide');
      }
    });
  });

  @error('date')
    alert('{{ $message }}');
  @enderror

  @if(session()->get('success'))
    alert('{{ session()->get("success") }}')
  @endif
</script>
</html>
