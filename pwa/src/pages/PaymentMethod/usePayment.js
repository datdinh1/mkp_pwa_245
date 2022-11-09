import React, { useCallback } from 'react'

export const usePayment = () => {

    const handleCreateBankAccount = useCallback(
        (data) => {
          console.log(data)
        },
        [],
    )
    

    const handleCreateCard = useCallback(
        (data) => {
          console.log(data)
        },
        [],
    )

  return ({
    handleCreateBankAccount,
    handleCreateCard
  })
}

