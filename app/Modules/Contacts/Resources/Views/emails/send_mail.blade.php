<style>
    @import url('https://fonts.googleapis.com/css?family=Overpass');
    html, body{
        margin: 0;
        padding: 0;
        font-family: 'Overpass', sans-serif;
    }
    .header{
        padding: 15px 25px;
        background: #f1f1f1;
    }
    .header p{
        margin: 0;
        padding: 5px 0;
    }
    .header p span{
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        padding: 0 10px 0 0;
    }
    .content{
        padding: 25px;
    }
</style>

<div class="header">
    <p class="from-name"><span>User Name : </span>{{ $name }}</p>
    <p class="from-email"><span>User E-Mail : </span>{{ $email }}</p>
</div>

<div class="content">
    {{ $comment }}
</div>



