<template>

  <div>
    选择时间区间
    <el-date-picker
      v-model="date"
      type="daterange"
      range-separator="~"
      start-placeholder="开始日期"
      end-placeholder="结束日期"
    />
  </div>

</template>
