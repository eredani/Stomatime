import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
class Row extends  Component {

    constructor(props) {
        super(props);
    }

    render() {

        return (
              <tr>
                <td>{this.props.serviciu.denumire}</td>
                <td>{this.props.serviciu.pret}&nbsp;RON</td>
            </tr>
                           

                );
    }
}
class Servicii extends Component {
    constructor(props)
    {
        super(props);
    }
    render()
    {
        var rows = [];
        this.props.specializare.servicii.forEach((serviciu,key)=>{
            console.log(serviciu);
            rows.push(<Row key={key} serviciu={serviciu}/>);

        });
        return(
           
               <div  className="col-lg-3 col-md-4 col-sm-6 d-flex text-center">
                        <div className="our-team-main">
        
                        <div className="team-front">
                            <h2>{this.props.specializare.specializare}</h2>
                           
                            <table className="table">
                            <thead>
                            <tr>
                            <th>Name</th>
                            <th>Price</th>
                            </tr>
                            </thead>

                            <tbody>
                            {rows}
                            </tbody>


                            <tfoot>
                            <tr>
                            <th>Name</th>
                            <th>Price</th></tr>
                        </tfoot>
                        </table>
                        
                        </div>
                    </div>
                    </div>
        );
    }
}
class Main extends  Component
{
    constructor(props)
    {
        super(props);
        this.state={
           data:[]
        };
    }
    componentWillMount()
    {
        try {
            axios.get(`https://stomatime.com/api/specializari/`+ window.config.ID)
                .then(res => {
                    this.setState({
                        data:res.data
                    });
                });
        } catch (error) {
            console.log("Eroare la API");
        }
    }
    render()
    {
        var dataa=[];
        var specializari = this.state.data;
        this.state.data.forEach((spec,key)=>{
            if(spec.servicii.length>0)
            {
                console.log(spec);
            dataa.push(<Servicii specializare={spec} count={key} key={key} />);
            }
        })
        return (
            <div className="container-fluid">
            <div className="row">
            {dataa}
            </div>
            </div>
        );
    }
}
if(document.getElementById('serviciireact'))
{
    ReactDOM.render(<Main/>, document.getElementById('serviciireact'));
}
