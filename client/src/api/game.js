import request from '@/utils/request'

export function groupGet() {
  const data = {
    cmd: 106,
    param: {

    }
  }

  var ret = request({
    url: 'http://192.168.1.127:8102',
    method: 'post',
    data
  })

  // test todo 这里为什么是空对象, 而gameGroup.vue中调用方法获取的不是空
  console.log('ret = ' + JSON.stringify(ret))
  return ret
}
