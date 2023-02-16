import React from 'react';

const CommonProfileCard = (props) => {
    return (
        <div>
            {props.isOpenProfileCard ? (
                <div>
                    {props.user_id}
                </div>
            ) : (
                <></>
            )}
        </div>     
    )
}

export default CommonProfileCard;