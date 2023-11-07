@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- Begin:: Row and Column input box -->
                    <div class="row">
                        <div class="col-3">
                            <label for="rows" class="form-label">Rows:</label>
                            <input type="number" class="form-control" name="rows" id="rows" min="1" required placeholder="Rows">
                        </div>

                        <div class="col-3">
                            <label for="columns" class="form-label">Columns:</label>
                            <input type="number" class="form-control" name="columns" id="columns" min="1" required placeholder="Columns">
                        </div>
                        <div class="col-4 mt-4">
                            <button class="btn btn-primary" id="btnGenerate">Generate Matrix</button>
                            <button class="btn btn-danger" id="btnReset">Reset</button>
                        </div>
                    </div>
                    <!-- End:: Row and Column input box -->


                </div>
                <!-- Begin:: Table -->
                <table class="table table-bordered" id="matrix-table">

                </table>
                <!-- End:: Table -->
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        // Event handler for "Generate Matrix" button
        $("#btnGenerate").click(function() {
            var rows = parseInt($("#rows").val());
            var columns = parseInt($("#columns").val());
            generateMatrix(rows, columns);
        });

        $("#btnReset").click(function() {
            $("#rows").val("");
            $("#columns").val("");
            $("#matrix-table").html("");
        });

        function generateMatrix(rows, columns) {
            var matrixTable = '<tr>';
            matrixTable += '<th>#</th>';
            matrixTable += '<th colspan="' + (columns) + '">Input Data</th>';
            matrixTable += '<th>Ans</th>';
            matrixTable += '</tr>';

            var rowStatus = 1;
            for (var i = 0; i < rows; i++) {
                matrixTable += '<tr id="' + rowStatus.toString() + '">';
                if (rowStatus === 1) {
                            matrixTable += '<td>Addition</td>';
                        } else if (rowStatus === 2) {
                            matrixTable += '<td>Multiplication</td>';
                        } else {
                            matrixTable += '<td>Subtraction</td>';
                        }

                for (var j = 0; j < columns; j++) {
                   
                    
                    matrixTable += '<td><input type="text" class="form-control matrix-input"></td>';
                    
                }
                matrixTable += '<td><input type="text" readonly class="form-control matrix-result"></td>';
                matrixTable += '</tr>';

                if (rowStatus == 3) {
                    rowStatus = 0;
                }
                rowStatus++;
            }


            $("#matrix-table").html(matrixTable);

            //all textbox blur event
            $(".matrix-input").on("change paste keyup cut select", function() {
                calculateRow($(this).closest("tr"));
            });
        }

        function calculateRow(row) {
            var sum = 0;
            var multiplication = 0;
            var subtraction = 0;

            var allEmpty = row.attr('id') == "2" && row.find(".matrix-input").toArray().every(function(input) {
            return $(input).val().trim() === "";
        });

            // Each input value get and calculate for <tr>
            row.find(".matrix-input").each(function(index) {
                var value = parseFloat($(this).val()) || 0;
                if (row.attr('id') == "1") {
                    sum += value;
                } else if (row.attr('id') == "2") {
                   
                    if (index === 0 && value === 0) {
                        multiplication = 0;
                    } else if (allEmpty) {
                        multiplication = 0; // Set multiplication to zero if all inputs are empty
                    } else {
                        if (value !== 0) {
                            multiplication = (multiplication === 0) ? value : multiplication * value;
                        }
                    }

                } else if (row.attr('id') == "3") {
                    if (index === 0) {
                        subtraction = value; // Set the first time value subtraction
                    } else {
                        subtraction -= value; // Subtract the subsequent values
                    }
                }
            });


            
            // Update the result
            if (row.attr('id') == "1") {
                row.find(".matrix-result").eq(0).val(sum.toFixed(2));
            } else if (row.attr('id') == "2") {
                row.find(".matrix-result").eq(0).val(multiplication.toFixed(2));
            } else if (row.attr('id') == "3") {

                row.find(".matrix-result").eq(0).val(subtraction.toFixed(2));
            }
        }

    });
</script>
@endsection