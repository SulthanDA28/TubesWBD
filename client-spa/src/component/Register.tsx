import {
    Box,
    VStack,
    Heading, 
} from '@chakra-ui/layout'
import { FormControl,
        FormLabel,
       } from '@chakra-ui/form-control'
import { Button,Input } from '@chakra-ui/react'
import React from 'react'
import axios from 'axios'

function Register() {
    const [username, setUsername] = React.useState('')
    const [password, setPassword] = React.useState('')

    const register = () => {
        if (/\s/.test(username) || /\s/.test(password)) {
            alert('Invalid username or password')
        }
        else if(username==='' || password===''){
            alert('Please fill all the fields')
        }
        else if (username.length < 5 || password.length < 5) {
            alert('Username and password must be at least 5 characters')
        }
        else {
            console.log('Registering...')
            console.log(username)
            console.log(password)
            // nanti disini register ke API
            axios.post('http://localhost:3030/register', {
                username: username,
                password: password
            }).then((res)=>{
                if(res.data.message === 'error'){
                    alert('Username already exists')
                }
                else{
                    alert('Register success')
                    window.location.href = '/login'
                }
            })

        }
    }

  return (
      <Box
      w={['full','md']}
      p={[8,10]}
      mx='auto'
      border={['none','1px solid gray']}
      mt={[20,'10hv']}
      borderRadius={10}
      borderColor={['','gray.200']}
      >
        <VStack
        spacing={4}
        align='flex-start'
        w='full'
        >
          <VStack
          spacing={1}
          w={['full']}
          align={['flex-start','center']}
          >
            <Heading>
              Register
            </Heading>
          </VStack>
          <FormControl>
          </FormControl>
          <FormControl>
              <FormLabel>
                Username
              </FormLabel>
              <Input variant={'filled'} value={username} onChange={(e)=>setUsername(e.target.value)}/>
          </FormControl>
          <FormControl>
              <FormLabel>
                Password
              </FormLabel>
              <Input variant={'filled'} type='password' value={password} onChange={(e)=>setPassword(e.target.value)}/>
          </FormControl>
          <Button colorScheme='facebook' w={'full'} onClick={register}>
            Register
          </Button>
        </VStack>
        <FormLabel>
          Already have an account? <a href='/login'>Login</a>
        </FormLabel>
      </Box>
  )
}

export default Register