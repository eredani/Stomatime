import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
if(document.getElementById('medicreact'))
{
    const medicID = window.config.medicID;
    const cabID = window.config.ID;
    class Doctor extends Component {
        constructor(props){
            super(props);
            this.state ={
                weeks:["duminica","luni","marti","miercuri","joi","vineri","sambata"],
                day:null
            };
            this.curentDate=this.curentDate.bind(this);
        } 
        curentDate() {
            var date = new Date();
            var ora = date.getHours();
            var minute = date.getMinutes();
            ora = ora % 24;
            ora = ora ? ora : 0;
            ora = ora < 10 ? '0'+ora : ora;
            minute = minute < 10 ? '0'+minute : minute;
            var time = ora + ':' + minute;
            return time;
        }
        componentWillMount()
        {
            var date = new Date();
            var day = this.state.weeks[date.getDay()];
            this.setState({day:day});
        }
        render()
        {
            var info=this.props.info;
            var orar=[];
            var status;
            this.state.weeks.forEach((day,key)=>{
                info.forEach((doctor) => {
                if(doctor.orar!==null)
                {
                if(doctor.orar[day])
                {
                    orar.push(<div className="col-lg-6 col-md-4 col-sm-4  text-center" key={key}> <p className="text-center"><b>{day.charAt(0).toUpperCase()}{day.slice(1)}: </b>{doctor.orar[day].start}-{doctor.orar[day].stop}</p></div>)
                }
                if(doctor.orar[this.state.day])
                {

                    if(this.curentDate() < doctor.orar[this.state.day].stop  &&  this.curentDate() > doctor.orar[this.state.day].start)
                    {
                        status=(<span className="badge badge-success">Disponibil</span>);
                    }
                    else
                    {
                        status=(<span className="badge badge-danger">Indisponibil</span>);
                    }
                }
                else
                {
                    status=(<span className="badge badge-danger">Indisponibil</span>);
                }
                }
                else
                {
                    status=(<span className="badge badge-danger">Indisponibil</span>);
                }
            });
        });
            return(
                <div className="row">
                {status}
               {orar}
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
                medic:[],
            }
        }
        componentWillMount()
        {
            try {
                axios.get(`https://stomatime.com/api/medic/`+ cabID+`/`+medicID)
                    .then(res => {
                        this.setState({
                            medic:res.data
                        });
                    })
            } catch (error) {
                console.log("Eroare la API");
            }
        }

        render()
        {
            return(
                <div className="container-fluid">
                    <br/>
                    <Doctor info={this.state.medic}/>
                   
                </div>
            );
        }
    }
    ReactDOM.render(<Main/>, document.getElementById('medicreact'));
}