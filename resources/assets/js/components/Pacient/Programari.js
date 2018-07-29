
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
if(document.getElementById('reactprogramari'))
{
    const API = 'https://stomatime.com/programari/me';
    class Modal extends Component{

        render()
        {
            var data= this.props.data;
            return(
                <div className="text-center">
                <button type="button" className="btn btn-primary" data-toggle="modal" data-target={"#set"+data.id}>
                <i className="fa fa-pencil-square-o"/>
                </button>

              
                <div className="modal" id={"set"+data.id}>
                <div className="modal-dialog">
                    <div className="modal-content">

                  
                    <div className="modal-header">
                        <h4 className="modal-title">{data.cabinet} | {data.medic}</h4>
                        <button type="button" className="close" data-dismiss="modal">&times;</button>
                    </div>

                   
                    <div className="modal-body">
                        
                    </div>
                    <div className="modal-footer">
                        <button type="button" className="btn btn-danger" data-dismiss="modal">Închide</button>
                    </div>
                    </div>
                </div>
                </div>
                </div>
            );
        }
    }
    class Row extends Component{

        render()
        {
            var prog=this.props.programare;
            return(
                <tr>
                    <td><a href={"https://stomatime.com/view/"+prog.id_cab}>{prog.cabinet}</a></td>
                    <td><a href={"https://stomatime.com/view/"+prog.id_cab+"/medic/"+prog.id_doctor}>{prog.medic}</a></td>
                    <td>+{prog.numar}</td>
                    <td>{prog.data}</td>
                    <td>{prog.ora}</td>
                    <td>{prog.status==0 ? <span className="badge badge-info">Asteptare</span> : <span className="badge badge-success">Acceptat</span>}</td>
                    <td>{prog.confirmat==0 ? <span className="badge badge-info">Neconfirmat</span> : <span className="badge badge-success">Confirmat</span>}</td>
                    <td><Modal data={prog}/></td>
                    </tr>
            );
        }
    }
    class Main extends Component{
        constructor(props)
        {
            super(props);
            this.state = {
                date: []
              };
        }

        componentDidMount()
        {
            axios.get(API)
            .then((res) => {
            this.setState({
                date:res.data
                
            });
            })
        }
        render()
        {
            var rows=[];
            this.state.date.forEach((programare,key)=>{
                rows.push(<Row programare={programare} key={key}/>)
            });
            return(
               <table className="table text-center">
                   <thead>
                       <tr>
                           <th>Cabinet</th>
                           <th>Doctor</th>
                           <th>Număr</th>
                           <th>Dată</th>
                           <th>Oră</th>
                           <th>Status</th>
                           <th>Confirmat</th>
                           <th>Setări</th>
                           </tr>
                    </thead>
                    <tbody>
                        {rows}
                </tbody>
                    <tfoot>
                    <tr>
                           <th>Cabinet</th>
                           <th>Doctor</th>
                           <th>Număr</th>
                           <th>Dată</th>
                           <th>Oră</th>
                           <th>Status</th>
                           <th>Confirmat</th>
                           <th>Setări</th>
                           </tr>
                </tfoot>
                   </table>
            );
        }
    }
    ReactDOM.render(<Main/>, document.getElementById('reactprogramari'));
}