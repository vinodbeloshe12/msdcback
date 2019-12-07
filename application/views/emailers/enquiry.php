<html>

<body>
    <div style="width: 100%;">
        <table style="width:600px;margin: 0 auto;border:1px solid #f1ecec;">
            <tr>
                <th style="border-bottom: 2px solid #7f1a1a;padding:15px 3px;">
                    <img width="250p" src="https://malvantarkarlitourplanner.com/assets/images/logo.png" alt=""
                        style="float:left;">
                </th>
            </tr>
            <tr>
                <td style="padding:25px 10px;">

                    <p style="font-family: 'PT Sans', sans-serif;font-size:1em;line-height:1.4em;color: #928b8b;">We
                        have
                        new Enquiry from <b><?php echo $data["name"]; ?><b></p>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="    width: 80%;
                    margin: 0 auto;
                    border-collapse: collapse;
                    border: 1px solid #eaeaea;">
                        <tr>
                            <td style="border-bottom: 1px solid #f1f1f1;
                           padding: 5px;
    background: whitesmoke;
    width: 30%;">
                                Name
                            </td>
                            <td style="border-bottom: 1px solid #f1f1f1;
                            padding: 5px;"><?php echo $data["name"] ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #f1f1f1;
                           padding: 5px;
    background: whitesmoke;
    width: 30%;">
                                Package Name
                            </td>
                            <td style="border-bottom: 1px solid #f1f1f1;
                            padding: 5px;"><?php echo $data["package_name"] ?></td>
                        </tr>
                       
                        <tr>
                            <td style="border-bottom: 1px solid #f1f1f1;
                            padding: 5px;
     background: whitesmoke;
     width: 30%;">
                                Phone
                            </td>
                            <td style="border-bottom: 1px solid #f1f1f1;
                            padding: 5px;"><?php echo $data["phone"] ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #f1f1f1;
                           padding: 5px;
    background: whitesmoke;
    width: 30%;">
                                Email
                            </td>
                            <td style="border-bottom: 1px solid #f1f1f1;padding: 5px;"><?php echo $data["email"] ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #f1f1f1;
                           padding: 5px;
    background: whitesmoke;
    width: 30%;">
                                City
                            </td>
                            <td style="border-bottom: 1px solid #f1f1f1;
                            padding: 5px;"><?php echo $data["city"] ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #f1f1f1;
                           padding: 5px;
    background: whitesmoke;
    width: 30%;">
                                Arrival Date
                            </td>
                            <td style="border-bottom: 1px solid #f1f1f1;
                            padding: 5px;"><?php echo $data["arrival_date"] ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #f1f1f1;
                           padding: 5px;
    background: whitesmoke;
    width: 30%;">
                                Deputure Date
                            </td>
                            <td style="border-bottom: 1px solid #f1f1f1;
                            padding: 5px;"><?php echo $data["deputure_date"] ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #f1f1f1;
                           padding: 5px;
    background: whitesmoke;
    width: 30%;">
                                No. of Adults
                            </td>
                            <td style="border-bottom: 1px solid #f1f1f1;
                            padding: 5px;"><?php echo $data["adults"] ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #f1f1f1;
                           padding: 5px;
    background: whitesmoke;
    width: 30%;">
                                No. of Childrens
                            </td>
                            <td style="border-bottom: 1px solid #f1f1f1;
                            padding: 5px;"><?php echo $data["childrens"] ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #f1f1f1;
                           padding: 5px;
    background: whitesmoke;
    width: 30%;">
                                Min. Price
                            </td>
                            <td style="border-bottom: 1px solid #f1f1f1;
                            padding: 5px;"><?php echo $data["min_price"] ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #f1f1f1;
                           padding: 5px;
    background: whitesmoke;
    width: 30%;">
                                Max. Price
                            </td>
                            <td style="border-bottom: 1px solid #f1f1f1;
                            padding: 5px;"><?php echo $data["max_price"] ?></td>
                        </tr>
                    </table>

                </td>
            </tr>


        </table>
    </div>

</body>

</html>