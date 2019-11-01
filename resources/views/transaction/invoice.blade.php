<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Invoice : {{$invoice}}</h4>
	</center>

	<table class='table'>
		<thead>
			<tr>
                <th>No</th>
                <th>Nama Item</th>
                <th>Harga Satuan</th>
                <th>Total Beli</th>
                <th>Total Harga</th>
			</tr>
		</thead>
		<tbody>
            @php 
                $i=1; 
                $totbyr=0;
            @endphp
            @foreach(Cart::getContent() as $data)
            @php 
				$tempTot = $data->price * $data->quantity
            @endphp
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$data->name}}</td>
				<td>{{number_format($data->price, 2, ',', '.')}}</td>
				<td>{{$data->quantity}}</td>
				<td>{{number_format($tempTot,2,',','.')}}</td>
            </tr>
				$tempTot
                $totbyr = $totbyr+$tempTot
			@endforeach
			
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td>Total</td>
				<td>{{number_format(Cart::getSubTotal(), 2, ',', '.')}}</td>
				<td>{{Cart::getTotalQuantity()}}</td>
				<td>{{number_format(Cart::getTotal(), 2, ',', '.')}}</td>
			</tr>
		</tfoot>
	</table>
        BAYAR       : {{$pembayaran}}
		Total Bayar : {{number_format(Cart::getTotal(), 2, ',', '.')}}
</body>
</html>
@php 
	Cart::clear()
@endphp