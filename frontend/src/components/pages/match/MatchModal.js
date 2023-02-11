import React from "react";

const MatchModal = (props) => {
    const date = Date.now();

    const overlay = {
        position: "fixed",
        top: 0,
        left: 0,
        width: "100%",
        height: "100%",
        backgroundColor: "rgba(0,0,0,0.5)",
    
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
    };
    
    const modalContent = {
        background: "white",
        padding: "10px",
        borderRadius: "3px",
    };

    const matchModalImagesStyle = {
        float: 'left',
    };

    function closeMatchModal(event) {
        const target = event.target.className;
        if (target === "matchModal") {
            props.setIsOpenMatchModal(false);
        }
    }

    return (
        <div>
            {props.isOpenMatchModal ? (
                <div className='matchModal' onClick={(event) => closeMatchModal(event)} style={overlay}>
                    <div className="matchModalContent" style={modalContent}>
                        <h2 style={{'text-align': 'center'}}>Match!</h2>
                        <div style={matchModalImagesStyle}>
                            <img src={props.selfPicture + "?" + date} style={{ width: '200px' }} alt='picture'></img>
                            <img src={props.matchIcon} style={{ width: '50px' }} alt='picture'></img>
                            <img src={props.pictureCroppedStash + "?" + date} style={{ width: '200px' }} alt='picture'></img>
                        </div>
                    </div>
                </div>
            ) : (
                <></>
            )}
        </div>
    )
};

export default MatchModal;